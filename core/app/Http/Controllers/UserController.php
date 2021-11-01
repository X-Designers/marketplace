<?php

namespace App\Http\Controllers;

use App\GeneralSetting;
use App\Lib\GoogleAuthenticator;
use App\Product;
use App\Rating;
use App\Sell;
use App\Transaction;
use App\User;
use App\WithdrawMethod;
use App\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Image;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function home()
    {
        $page_title = 'Dashboard';
        $user = auth()->user();
        $uploadedProductCount = Product::where('user_id',$user->id)->where('status',1)->count();
        $purchasedProductCount = Sell::where('user_id',$user->id)->where('status',1)->count();
        $transactionCount = Transaction::where('user_id',$user->id)->count();
        $totalSell = Sell::where('author_id',$user->id)->where('status',1)->count();

        $sell['month'] = collect([]);
        $sell['amount'] = collect([]);

        $sell_chart = Sell::whereYear('created_at', '=', date('Y'))->orderBy('created_at')->groupBy(DB::Raw("MONTH(created_at)"))->get();

        $sell_chart_data = $sell_chart->map(function ($query) use ($sell,$user) {
            $sell['month'] = $query->created_at->format('F');
            $sell['amount'] = $query->where('author_id',$user->id)->where('status',1)->whereMonth('created_at',$query->created_at)->sum('product_price');
            return $sell;
        });

        $thisMonthRealeased = $user->products()->whereMonth('created_at',now())->where('status',1)->count();
        $thisMonthPurchased = $user->buy()->whereMonth('created_at',now())->where('status',1)->count();

        return view($this->activeTemplate . 'user.dashboard', compact('page_title','user','uploadedProductCount','purchasedProductCount','transactionCount','sell_chart_data','thisMonthRealeased','thisMonthPurchased','totalSell'));
    }

    public function profile()
    {
        $data['page_title'] = "Profile Setting";
        $data['user'] = Auth::user();
        return view($this->activeTemplate. 'user.profile-setting', $data);
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => "sometimes|required|max:80",
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => 'mimes:png,jpg,jpeg',
            'cover_image' => 'mimes:png,jpg,jpeg'
        ],[
            'firstname.required'=>'First Name Field is required',
            'lastname.required'=>'Last Name Field is required'
        ]);

        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'city' => $request->city,
            'country' => $user->address->country,
        ];

        $in['description'] = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $user->username . '.jpg';
            $location = 'assets/images/user/profile/' . $filename;
            $in['image'] = $filename;

            $path = './assets/images/user/profile/';
            $link = $path . $user->image;
            if (file_exists($link)) {
                @unlink($link);
            }
            $size = imagePath()['profile']['user']['size'];
            $image = Image::make($image);
            $size = explode('x', strtolower($size));
            $image->resize($size[0], $size[1]);
            $image->save($location);
        }

        if($request->hasFile('cover_image')) {
            try{

                $location = imagePath()['profile']['cover']['path'];
                $size = imagePath()['profile']['cover']['size'];
                $old = $user->cover_image;
                $coverImage = uploadImage($request->cover_image, $location , $size, $old);
                $in['cover_image'] = $coverImage;

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $user->fill($in)->save();
        $notify[] = ['success', 'Profile Updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $data['page_title'] = "CHANGE PASSWORD";
        return view($this->activeTemplate . 'user.password', $data);
    }

    public function submitPassword(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password Changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'Current password not match.'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Deposit History
     */
    public function depositHistory()
    {
        $page_title = 'Deposit History';
        $empty_message = 'No history found.';
        $user = auth()->user();
        $logs = $user->deposits()->where('order_number', null)->with(['gateway'])->latest()->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('page_title', 'empty_message', 'logs','user'));
    }

    /*
     * Withdraw Operation
     */

    public function withdrawMoney()
    {
        $data['withdrawMethod'] = WithdrawMethod::whereStatus(1)->get();
        $data['page_title'] = "Withdraw Money";
        return view(activeTemplate() . 'user.withdraw.methods', $data);
    }

    public function withdrawStore(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your Requested Amount is Smaller Than Minimum Amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your Requested Amount is Larger Than Maximum Amount.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $user->balance) {
            $notify[] = ['error', 'Your do not have Sufficient Balance For Withdraw.'];
            return back()->withNotify($notify);
        }


        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = getAmount($afterCharge * $method->rate);

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = getAmount($request->amount);
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return redirect()->route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $data['withdraw'] = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->latest()->firstOrFail();
        $data['page_title'] = "Withdraw Preview";
        return view($this->activeTemplate . 'user.withdraw.preview', $data);
    }


    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->latest()->firstOrFail();

        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }
        $this->validate($request, $rules);
        $user = auth()->user();

        if (getAmount($withdraw->amount) > $user->balance) {
            $notify[] = ['error', 'Your Request Amount is Larger Then Your Current Balance.'];
            return back()->withNotify($notify);
        }

        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['withdraw']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory.'/'.uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }


        $withdraw->status = 2;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->save();



        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = getAmount($withdraw->amount);
        $transaction->post_balance = getAmount($user->balance);
        $transaction->charge = getAmount($withdraw->charge);
        $transaction->trx_type = '-';
        $transaction->details = getAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => getAmount($withdraw->final_amount),
            'amount' => getAmount($withdraw->amount),
            'charge' => getAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => getAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => getAmount($user->balance),
            'delay' => $withdraw->method->delay
        ]);

        $notify[] = ['success', 'Withdraw Request Successfully Send'];
        return redirect()->route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog()
    {
        $data['page_title'] = "Withdraw Log";
        $data['withdraws'] = Withdrawal::where('user_id', Auth::id())->where('status', '!=', 0)->with('method')->latest()->paginate(getPaginate());
        $data['empty_message'] = "No Data Found!";
        return view($this->activeTemplate.'user.withdraw.log', $data);
    }


    public function show2faForm()
    {
        $gnl = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $secret);
        $prevcode = $user->tsc;
        $prevqr = $ga->getQRCodeGoogleUrl($user->username . '@' . $gnl->sitename, $prevcode);
        $page_title = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('page_title', 'secret', 'qrCodeUrl', 'prevcode', 'prevqr'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);

        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);

        if ($oneCode === $request->code) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->tv = 1;
            $user->save();


            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);


            $notify[] = ['success', 'Google Authenticator Enabled Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $ga = new GoogleAuthenticator();

        $secret = $user->tsc;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {

            $user->tsc = null;
            $user->ts = 0;
            $user->tv = 1;
            $user->save();


            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);


            $notify[] = ['success', 'Two Factor Authenticator Disable Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->withNotify($notify);
        }
    }

    public function purchasedProduct(){
        $page_title = "Purchased Products";

        $products = Sell::where('user_id',auth()->user()->id)->paginate(getPaginate());
        $empty_message = 'No data found';

        return view($this->activeTemplate.'user.product.purchased', compact('page_title', 'products','empty_message'));

    }

    public function rating(Request $request){

        $request->validate([
            'rating' => 'required|integer|gt:0|max:5',
            'product_id' => 'required|integer|gt:0',
            'review' => 'required',
        ]);

        $product = Sell::where('product_id',$request->product_id)->where('user_id',auth()->user()->id)->where('status',1)->first();
        $user = auth()->user();

        if ($product == null) {
            $notify[] = ['error', 'Something went wrong'];
            return back()->withNotify($notify);
        }

        $rating = new Rating();
        $rating->product_id = $request->product_id;
        $rating->user_id = $user->id;
        $rating->rating = $request->rating;
        $rating->review = $request->review;
        $rating->save();

        $totalRatingProduct = $product->product->total_rating + $request->rating;
        $totalResponseProduct = $product->product->total_response + 1;
        $avgRatingProduct = round($totalRatingProduct / $totalResponseProduct);

        $product->product->total_rating = $totalRatingProduct;
        $product->product->total_response = $totalResponseProduct;
        $product->product->avg_rating = $avgRatingProduct;
        $product->product->save();

        $totalRatingAuthor = $product->product->user->total_rating + $request->rating;
        $totalResponseAthor = $product->product->user->total_response + 1;
        $avgRatingAuthor = round($totalRatingAuthor / $totalResponseAthor);

        $product->product->user->total_rating = $totalRatingAuthor;
        $product->product->user->total_response = $totalResponseAthor;
        $product->product->user->avg_rating = $avgRatingAuthor;
        $product->product->user->save();


        $notify[] = ['success', 'Thanks for your review'];
        return back()->withNotify($notify);
    }

    public function download($id)
    {
        $product = Product::findOrFail(Crypt::decrypt($id));
        $productCheck = Sell::where('product_id',$product->id)->where('user_id',auth()->user()->id)->where('status',1)->first();

        if ($productCheck == null) {
            $notify[] = ['error', 'You are not allowed to download this'];
            return back()->withNotify($notify);
        }

        $file = $product->file;
        $full_path = 'assets/product/' . $file;
        $title = str_replace(' ','_',strtolower($product->name));
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($full_path);
        header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }

    public function invoice($id)
    {
        $page_title = 'Invoice';
        $product = Product::findOrFail(Crypt::decrypt($id));
        $productCheck = Sell::where('product_id',$product->id)->where('user_id',auth()->user()->id)->where('status',1)->first();

        if ($productCheck == null) {
            $notify[] = ['error', 'You are not allowed to download invoice'];
            return back()->withNotify($notify);
        }

        $filename = strtolower(str_replace(' ','_',$productCheck->product->name));
        return view($this->activeTemplate.'user.product.invoice', compact('page_title', 'productCheck','filename'));
    }

    public function transaction()
    {
        $page_title = 'Transaction Logs';
        $transactions = Transaction::where('user_id',Auth::id())->orderBy('id','desc')->paginate(getPaginate());
        $empty_message = 'No transactions.';
        return view($this->activeTemplate.'user.transaction', compact('page_title', 'transactions', 'empty_message'));
    }

    public function sellLog()
    {
        $page_title = 'Sell Logs';
        $sells = Sell::where('author_id',Auth::id())->where('status',1)->with('product')->orderBy('id','desc')->paginate(getPaginate());
        $empty_message = 'No data found.';
        return view($this->activeTemplate.'user.sell_log', compact('page_title', 'sells', 'empty_message'));
    }

    public function trackSell()
    {
        $page_title = 'Track Sells';
        $result = null;
        return view($this->activeTemplate.'user.track_sell', compact('page_title','result'));
    }

    public function trackSellSearch(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $result = Sell::where('code',$request->code)->where('author_id',auth()->user()->id)->where('status',1)->first();

        if ($result) {
            $page_title = 'Track Sells Seach';
            return view($this->activeTemplate.'user.track_sell', compact('page_title', 'result'));
        }else{
            $notify[] = ['error', 'No result found with this code'];
            return redirect()->route('user.track.sell')->withNotify($notify);
        }
    }

    public function emailAuthor(Request $request)
    {
        $request->validate([
            'author' => 'required',
            'message' => 'required',
        ]);

        $author = User::where('status',1)->where('username',$request->author)->firstOrFail();

        notify($author, 'MAIL_TO_ATHOR', [
            'reply_to' => auth()->user()->email,
            'message' => $request->message
        ]);

        $notify[] = ['success', 'You have successfully sent your message.'];
        return back()->withNotify($notify);

    }
}
