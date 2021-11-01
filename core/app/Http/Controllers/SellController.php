<?php

namespace App\Http\Controllers;

use App\GeneralSetting;
use App\Level;
use App\Order;
use App\Product;
use App\Sell;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Crypt;

class SellController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'license' => 'required|numeric|in:1,2',
            'product_id' => 'required',
        ]);

        $product = Product::where('status',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->findOrFail(Crypt::decrypt($request->product_id));

        if (auth()->user()) {

            if ($product->user->id == auth()->user()->id) {
                $notify[] = ['error', 'It is your own product. You are not allowed to purchase this'];
                return back()->withNotify($notify);
            }
        }

        if(auth()->user()){
            $orderNumber = auth()->user()->id;
        }else{
            if(session()->has('order_number')){
                $orderNumber = session()->get('order_number');
            }
            if(!session()->has('order_number')){
                $orderNumber = getTrx(8);
                session()->put('order_number',$orderNumber);
            }
        }

        $general = GeneralSetting::first();

        if ($product->support == 1 && $request->extented_support) {

            $support_time = Carbon::now()->addMonths($general->extended)->format('Y-m-d');

            if ($request->license == 1) {

                if ($product->support_discount) {

                    $tempCharge = ($product->regular_price * $product->support_charge) / 100;
                    $lessCharge = ($tempCharge * $product->support_discount) / 100;
                    $supportFee = $tempCharge - $lessCharge;
                    $totalPrice = $product->regular_price + $supportFee;

                }else{
                    $supportFee = ($product->regular_price * $product->support_charge) / 100;
                    $totalPrice = $product->regular_price + $supportFee;
                }
            }

            if ($request->license == 2) {
                if ($product->support_discount) {

                    $tempCharge = ($product->extended_price * $product->support_charge) / 100;
                    $lessCharge = ($tempCharge * $product->support_discount) / 100;
                    $supportFee = $tempCharge - $lessCharge;
                    $totalPrice = $product->extended_price + $supportFee;

                }else{
                    $supportFee = ($product->extended_price * $product->support_charge) / 100;
                    $totalPrice = $product->extended_price + $supportFee;
                }
            }
        }


        if(($product->support == 0) || ($product->support == 1 && !$request->extented_support) ) {

            $supportFee = 0;

            if ($request->license == 1) {
                $totalPrice = $product->regular_price;
            }
            if ($request->license == 2) {
                $totalPrice = $product->extended_price;
            }
        }

        if ($product->support == 1 && !$request->extented_support) {
            $support_time = Carbon::now()->addMonths($general->regular)->format('Y-m-d');
        }

        if ($product->support == 0) {
            $support_time = null;
        }

        $order = new Order();
        $order->order_number = $orderNumber;
        $order->code = getTrx(20);
        $order->author_id = $product->user->id;
        $order->product_id = $product->id;
        $order->license = $request->license;
        $order->support = $product->support;
        $order->support_time = $support_time;
        $order->support_fee = $supportFee;
        $order->product_price = $request->license == 1 ? $product->regular_price : ($request->license == 2 ? $product->extended_price:'');
        $order->total_price	= $totalPrice;
        $order->save();


        $notify[] = ['success', 'Product added to cart successfully'];
        return back()->withNotify($notify);
    }

    public function carts(){
        $page_title = 'Cart';

        if(auth()->user()){
            $user = auth()->user();
            Order::where('author_id',$user->id)->delete();
            $orders = Order::where('order_number',$user->id)->get();
        }else{
            $orders = Order::where('order_number',session()->get('order_number'))->get();
        }
        return view($this->activeTemplate . 'cart',compact('page_title','orders'));
    }

    public function removeCart($id){
        $order = Order::findOrFail(Crypt::decrypt($id));

        $order->delete();

        $notify[] = ['success', 'Product has been remove from cart successfully'];
        return back()->withNotify($notify);

    }

    public function checkoutPayment(Request $request){
        $request->validate([
            'wallet_type' => 'required|in:own,online',
        ]);

        $user = auth()->user();

        if ($request->wallet_type == 'own') {

            $orders = Order::where('order_number',$user->id)->get();

            if (count($orders) > 0) {

                $user = auth()->user();
                $totalPrice = $orders->sum('total_price');
                $gnl = GeneralSetting::first();

                if ($totalPrice > $user->balance) {
                    $notify[] = ['error', 'You do not have enough balance.'];
                    return back()->withNotify($notify);
                }

                if ($totalPrice <= $user->balance) {

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
                            'post_balance' => $author->balance,
                            'buyer_fee' => $author->levell->product_charge,
                            'amount' => $sell->total_price - ($sell->product->category->buyer_fee + (($sell->total_price * $author->levell->product_charge) / 100))
                        ]);
                    }

                    $user->balance = $user->balance - $totalPrice;
                    $user->save();

                    $transaction = new Transaction();
                    $transaction->user_id = $user->id;
                    $transaction->amount = $totalPrice;
                    $transaction->post_balance = $user->balance;
                    $transaction->charge = 0;
                    $transaction->trx_type = '-';
                    $transaction->details = getAmount($totalPrice) . ' ' . $gnl->cur_text .' Subtracted From Your Own Wallet For Purchasing Products.';
                    $transaction->trx =  getTrx();
                    $transaction->save();

                    $productList = '';

                    foreach ($orders as $item) {
                        $productList .= '# '.$item->product->name.'<br>';
                    }

                    notify($user, 'PRODUCT_PURCHASED', [
                        'method_name' => 'Own Wallet',
                        'currency' => $gnl->cur_text,
                        'total_amount' => getAmount($totalPrice),
                        'post_balance' => $user->balance,
                        'product_list' => $productList
                    ]);

                    foreach ($orders as $item) {
                        $item->delete();
                    }
                    session()->forget('order_number');

                    return redirect()->route('user.purchased.product');

                }


            }else{
                $notify[] = ['error', 'No products in your cart.'];
                return back()->withNotify($notify);
            }

        }

        if ($request->wallet_type == 'online') {
            $orders = Order::where('order_number',$user->id)->get();

            if (count($orders) > 0) {
                return redirect()->route('user.payment');
            }else{

                $notify[] = ['error', 'No products in your cart.'];
                return back()->withNotify($notify);
            }

        }

    }

}

