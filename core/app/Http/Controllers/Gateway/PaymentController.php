<?php

namespace App\Http\Controllers\Gateway;

use App\GeneralSetting;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GatewayCurrency;
use App\Deposit;
use App\Level;
use App\Order;
use App\Sell;
use Session;
use App\User;

class PaymentController extends Controller
{
    public function __construct()
    {
        return $this->activeTemplate = activeTemplate();
    }

    public function deposit()
    {

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $page_title = 'Deposit Methods';

        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'page_title'));
    }

    public function payment()
    {

        $orders = Order::where('order_number',auth()->user()->id)->get();

        if (count($orders) > 0) {
            $totalPrice = $orders->sum('total_price');
        }else{
            $notify[] = ['error', 'No products in your cart.'];
            return back()->withNotify($notify);
        }

        $page_title = 'Deposit Methods';

        $gatewayCurrency = GatewayCurrency::where('min_amount', '<' ,$totalPrice)->where('max_amount', '>' ,$totalPrice)->whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();

        return view($this->activeTemplate . 'user.payment.payment', compact('gatewayCurrency', 'page_title', 'totalPrice'));


    }

    public function depositInsert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
        ]);


        $user = auth()->user();
        $gate = GatewayCurrency::where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid Gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please Follow Deposit Limit'];
            return back()->withNotify($notify);
        }

        $charge = getAmount($gate->fixed_charge + ($request->amount * $gate->percent_charge / 100));
        $payable = getAmount($request->amount + $charge);
        $final_amo = getAmount($payable * $gate->rate);

        $data = new Deposit();
        $data->user_id = $user->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $request->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = getAmount($final_amo);
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->save();
        session()->put('Track', $data['trx']);
        return redirect()->route('user.deposit.preview');
    }

    public function paymentInsert(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
        ]);


        $orders = Order::where('order_number',auth()->user()->id)->get();

        if (count($orders) > 0) {

            $user = auth()->user();
            $totalPrice = $orders->sum('total_price');

            if ($totalPrice != $request->amount) {
                $notify[] = ['error', 'Something goes wrong.'];
                return redirect()->route('home')->withNotify($notify);
            }

            $gate = GatewayCurrency::where('method_code', $request->method_code)->where('currency', $request->currency)->first();

            if (!$gate) {
                $notify[] = ['error', 'Invalid Gateway'];
                return back()->withNotify($notify);
            }

            $charge = getAmount($gate->fixed_charge + ($request->amount * $gate->percent_charge / 100));
            $payable = getAmount($request->amount + $charge);
            $final_amo = getAmount($payable * $gate->rate);

            $data = new Deposit();
            $data->order_number = $orders[0]->order_number;
            $data->user_id = $user->id;
            $data->method_code = $gate->method_code;
            $data->method_currency = strtoupper($gate->currency);
            $data->amount = $request->amount;
            $data->charge = $charge;
            $data->rate = $gate->rate;
            $data->final_amo = getAmount($final_amo);
            $data->btc_amo = 0;
            $data->btc_wallet = "";
            $data->trx = getTrx();
            $data->try = 0;
            $data->status = 0;
            $data->save();

            session()->put('Track', $data['trx']);

            return redirect()->route('user.payment.preview');
        }


    }


    public function depositPreview()
    {

        $track = session()->get('Track');
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->firstOrFail();

        if (is_null($data)) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        if ($data->status != 0) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }

        $page_title = 'Deposit Preview';
        return view($this->activeTemplate . 'user.payment.preview', compact('data', 'page_title'));
    }

    public function paymentPreview()
    {

        $track = session()->get('Track');

        $data = Deposit::where('order_number',auth()->user()->id)->where('trx', $track)->orderBy('id', 'DESC')->firstOrFail();


        if (is_null($data)) {
            $notify[] = ['error', 'Invalid Payment Request'];
            return redirect()->route('home')->withNotify($notify);
        }
        if ($data->status != 0) {
            $notify[] = ['error', 'Invalid Payment Request'];
            return redirect()->route('home')->withNotify($notify);
        }
        $page_title = 'Payment Preview';
        return view($this->activeTemplate . 'user.payment.payment-preview', compact('data', 'page_title'));
    }


    public function depositConfirm()
    {

        $track = Session::get('Track');
        $deposit = Deposit::where('trx', $track)->orderBy('id', 'DESC')->with('gateway')->first();
        if (is_null($deposit)) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }
        if ($deposit->status != 0) {
            $notify[] = ['error', 'Invalid Deposit Request'];
            return redirect()->route(gatewayRedirectUrl())->withNotify($notify);
        }

        if ($deposit->method_code >= 1000) {
            $this->userDataUpdate($deposit);
            $notify[] = ['success', 'Your deposit request is queued for approval.'];
            return back()->withNotify($notify);
        }


        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];

            return redirect()->route( gatewayRedirectUrl())->withNotify($notify);
        }


        if (isset($data->redirect)) {

            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if(@$data->session){
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $page_title = 'Payment Confirm';

        return view($this->activeTemplate . $data->view, compact('data', 'page_title', 'deposit'));
    }

    public static function userDataUpdate($trx)
    {

        $general = GeneralSetting::first();
        $data = Deposit::where('trx', $trx)->first();

        if ($data->order_number == null) {

            if ($data->status == 0) {
                $data->status = 1;
                $data->save();

                $user = User::find($data->user_id);
                $user->balance += $data->amount;
                $user->save();

                $transaction = new Transaction();
                $transaction->user_id = $data->user_id;
                $transaction->amount = $data->amount;
                $transaction->post_balance = $user->balance;
                $transaction->charge = $data->charge;
                $transaction->trx_type = '+';
                $transaction->details = 'Deposit Via ' . $data->gateway_currency()->name;
                $transaction->trx = $data->trx;
                $transaction->save();

                notify($user, 'DEPOSIT_COMPLETE', [
                    'method_name' => $data->gateway_currency()->name,
                    'method_currency' => $data->method_currency,
                    'method_amount' => getAmount($data->final_amo),
                    'amount' => getAmount($data->amount),
                    'charge' => getAmount($data->charge),
                    'currency' => $general->cur_text,
                    'rate' => getAmount($data->rate),
                    'trx' => $data->trx,
                    'post_balance' => getAmount($user->balance)
                ]);


            }
        }

        if ($data->order_number) {

            $orders = Order::where('order_number',auth()->user()->id)->get();

            if (count($orders) > 0) {

                $user = User::find($data->user_id);
                $gnl = GeneralSetting::first();

                foreach ($orders as $item) {
                    $sell = new Sell();
                    $sell->code = $item->code;
                    $sell->author_id = $item->author_id;
                    $sell->user_id = $user->id;
                    $sell->product_id = $item->product_id;
                    $sell->license = $item->license;
                    $sell->support = $item->support;
                    $sell->support_time = $item->support_time;
                    $sell->support_fee = $item->support_fee;
                    $sell->product_price = $item->product_price;
                    $sell->total_price = $item->total_price;
                    $sell->status = 1;
                    $sell->save();

                    $sell->product->total_sell += 1;
                    $sell->product->save();

                    $levels = Level::get();
                    $author = $item->author;
                    $author->earning = $author->earning + ($sell->total_price - ($sell->product->category->buyer_fee + (($sell->total_price * $author->levell->product_charge) / 100)));
                    $author->balance += $sell->total_price;

                    if (($author->earning >= $author->levell->earning) && ($author->earning < $levels->max('earning'))) {
                        $author->level_id += 1;
                    }

                    $authorTransaction = new Transaction();
                    $authorTransaction->user_id = $author->id;
                    $authorTransaction->amount = $sell->total_price;
                    $authorTransaction->post_balance = $author->balance;
                    $authorTransaction->charge = 0;
                    $authorTransaction->trx_type = '+';
                    $authorTransaction->details = getAmount($authorTransaction->amount) . ' ' . $gnl->cur_text .' Added with Balance For selling a product named ' .$item->product->name;
                    $authorTransaction->trx =  getTrx();
                    $authorTransaction->save();

                    $author->balance = $author->balance - ($sell->product->category->buyer_fee + (($sell->total_price * $author->levell->product_charge) / 100));
                    $author->save();

                    $authorTransaction = new Transaction();
                    $authorTransaction->user_id = $author->id;
                    $authorTransaction->amount = $sell->product->category->buyer_fee + (($sell->total_price * $author->levell->product_charge) / 100);
                    $authorTransaction->post_balance = $author->balance;
                    $authorTransaction->charge = 0;
                    $authorTransaction->trx_type = '-';
                    $authorTransaction->details = $sell->product->category->buyer_fee + (($sell->total_price * $author->levell->product_charge) / 100) . ' ' . $gnl->cur_text .' Charged For selling a product named ' .$item->product->name;
                    $authorTransaction->trx =  getTrx();
                    $authorTransaction->save();

                    if ($item->license == 1) {
                        $licenseType = 'Regular';
                    }
                    if ($item->license == 2) {
                        $licenseType = 'Extended';
                    }

                    notify($author, 'PRODUCT_SOLD', [
                        'product_name' => $item->product->name,
                        'license' => $licenseType,
                        'currency' => $gnl->cur_text,
                        'product_amount' => getAmount($sell->product_price),
                        'support_fee' => getAmount($sell->support_fee),
                        'support_time' => $sell->support_time ? $sell->support_time : 'No support',
                        'trx' => $authorTransaction->trx,
                        'purchase_code' => $sell->code,
                        'post_balance' => getAmount($author->balance),
                        'buyer_fee' => $author->levell->product_charge,
                        'amount' => $sell->total_price - ($sell->product->category->buyer_fee + (($sell->total_price * $author->levell->product_charge) / 100))
                    ]);
                }

                $productList = '';

                foreach ($orders as $item) {
                    $productList .= '# '.$item->product->name.'<br>';
                }

                foreach ($orders as $item) {
                    $item->delete();
                }

                $data->status = 1;
                $data->save();

                $user->balance += $data->amount;

                $transaction = new Transaction();
                $transaction->user_id = $data->user_id;
                $transaction->amount = $data->amount;
                $transaction->post_balance = $user->balance;
                $transaction->charge = $data->charge;
                $transaction->trx_type = '+';
                $transaction->details = 'Payment Via ' . $data->gateway_currency()->name;
                $transaction->trx = $data->trx;
                $transaction->save();

                $user->balance -= $data->amount;
                $user->save();

                $transaction = new Transaction();
                $transaction->user_id = $data->user_id;
                $transaction->amount = $data->amount;
                $transaction->post_balance = $user->balance;
                $transaction->charge = $data->charge;
                $transaction->trx_type = '-';
                $transaction->details = getAmount($data->amount) . ' ' . $gnl->cur_text .' Subtracted From Your Balance For Purchasing Products.';
                $transaction->trx = $data->trx;
                $transaction->save();

                notify($user, 'PRODUCT_PURCHASED', [
                    'method_name' => $data->gateway_currency()->name,
                    'currency' => $gnl->cur_text,
                    'total_amount' => getAmount($data->amount),
                    'post_balance' => $user->balance,
                    'product_list' => $productList
                ]);

                session()->forget('order_number');
                session()->forget('cartCount');

                $notify[] = ['success', 'You have purchased successfully.'];
                return redirect()->route('user.purchased.product')->withNotify($notify);


            }else{
                $notify[] = ['error', 'No products in your cart.'];
                return back()->withNotify($notify);
            }
        }
    }


    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->status != 0) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $page_title = 'Deposit Confirm';
            $method = $data->gateway_currency();
            return view($this->activeTemplate . 'user.manual_payment.manual_confirm', compact('data', 'page_title', 'method'));
        }
        abort(404);
    }

    public function manualPaymentConfirm()
    {
        $track = session()->get('Track');


        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->where('order_number',auth()->user()->id)->first();


        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->status != 0) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $page_title = 'Payment Confirm';
            $method = $data->gateway_currency();
            return view($this->activeTemplate . 'user.manual_payment.manual_payment_confirm', compact('data', 'page_title', 'method'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->status != 0) {
            return redirect()->route(gatewayRedirectUrl());
        }

        $params = json_decode($data->gateway_currency()->gateway_parameter);

        $rules = [];
        $inputField = [];
        $verifyImages = [];

        if ($params != null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');

                    array_push($verifyImages, $key);
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


        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['deposit']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($params != null) {
            foreach ($collection as $k => $v) {
                foreach ($params as $inKey => $inVal) {
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
                                    $notify[] = ['error', 'Could not upload your ' . $inKey];
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
            $data->detail = $reqField;
        } else {
            $data->detail = null;
        }



        $data->status = 2; // pending
        $data->save();

        $gnl = GeneralSetting::first();

        notify($data->user, 'DEPOSIT_REQUEST', [
            'method_name' => $data->gateway_currency()->name,
            'method_currency' => $data->method_currency,
            'method_amount' => getAmount($data->final_amo),
            'amount' => getAmount($data->amount),
            'charge' => getAmount($data->charge),
            'currency' => $gnl->cur_text,
            'rate' => getAmount($data->rate),
            'trx' => $data->trx
        ]);

        $notify[] = ['success', 'You have deposit request has been taken.'];
        return redirect()->route('user.deposit.history')->withNotify($notify);
    }

    public function manualPaymentUpdate(Request $request)
    {
        $track = session()->get('Track');

        $data = Deposit::with('gateway')->where('status', 0)->where('trx', $track)->where('order_number',auth()->user()->id)->first();


        if (!$data) {
            return redirect()->route(gatewayRedirectUrl());
        }
        if ($data->status != 0) {
            return redirect()->route(gatewayRedirectUrl());
        }

        $params = json_decode($data->gateway_currency()->gateway_parameter);

        $rules = [];
        $inputField = [];
        $verifyImages = [];

        if ($params != null) {
            foreach ($params as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');

                    array_push($verifyImages, $key);
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


        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['deposit']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($params != null) {
            foreach ($collection as $k => $v) {
                foreach ($params as $inKey => $inVal) {
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
                                    $notify[] = ['error', 'Could not upload your ' . $inKey];
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
            $data->detail = $reqField;
        } else {
            $data->detail = null;
        }



        $data->status = 2; // pending
        $data->save();

        $gnl = GeneralSetting::first();

        $orders = Order::where('order_number',auth()->user()->id)->get();

        if (count($orders) > 0) {

            $user = auth()->user();

            foreach ($orders as $item) {
                $sell = new Sell();
                $sell->code = $item->code;
                $sell->author_id = $item->author_id;
                $sell->user_id = $user->id;
                $sell->product_id = $item->product_id;
                $sell->license = $item->license;
                $sell->support = $item->support;
                $sell->support_time = $item->support_time;
                $sell->support_fee = $item->support_fee;
                $sell->product_price = $item->product_price;
                $sell->total_price = $item->total_price;
                $sell->status = 0;
                $sell->save();
            }

            foreach ($orders as $item) {
                $item->delete();
            }

            notify($data->user, 'PAYMENT_REQUEST', [
                'method_name' => $data->gateway_currency()->name,
                'method_currency' => $data->method_currency,
                'method_amount' => getAmount($data->final_amo),
                'amount' => getAmount($data->amount),
                'charge' => getAmount($data->charge),
                'currency' => $gnl->cur_text,
                'rate' => getAmount($data->rate),
                'trx' => $data->trx
            ]);

            session()->forget('order_number');
            session()->forget('cartCount');

            $notify[] = ['success', 'Your payment request has been taken. Wait for the approval'];
            return redirect()->route('user.purchased.product')->withNotify($notify);


        }else{
            $notify[] = ['error', 'No products in your cart.'];
            return back()->withNotify($notify);
        }
    }
}
