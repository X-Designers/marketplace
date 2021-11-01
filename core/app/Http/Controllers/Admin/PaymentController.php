<?php

namespace App\Http\Controllers\Admin;

use App\Deposit;
use App\Gateway;
use App\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Level;
use App\Sell;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pending()
    {
        $page_title = 'Pending Payments';
        $empty_message = 'No pending payment.';
        $type = 'pending';
        $deposits = Deposit::where('order_number', '!=', null)->where('method_code', '>=', 1000)->where('status', 2)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        return view('admin.payment.log', compact('page_title', 'empty_message', 'deposits','type'));
    }


    public function approved()
    {
        $page_title = 'Approved Payments';
        $empty_message = 'No approved payment.';
        $deposits = Deposit::where('order_number', '!=', null)->where('method_code','>=',1000)->where('status', 1)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        $type = 'approved';
        return view('admin.payment.log', compact('page_title', 'empty_message', 'deposits','type'));
    }

    public function successful()
    {
        $page_title = 'Successful Payments';
        $empty_message = 'No successful payment.';
        $deposits = Deposit::where('order_number', '!=', null)->where('status', 1)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        $type = 'successful';
        return view('admin.payment.log', compact('page_title', 'empty_message', 'deposits','type'));
    }

    public function rejected()
    {
        $page_title = 'Rejected Payments';
        $empty_message = 'No rejected payment.';
        $type = 'rejected';
        $deposits = Deposit::where('order_number', '!=', null)->where('method_code', '>=', 1000)->where('status', 3)->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        return view('admin.payment.log', compact('page_title', 'empty_message', 'deposits','type'));
    }

    public function payment()
    {
        $page_title = 'Payment History';
        $empty_message = 'No payment history available.';
        $deposits = Deposit::where('order_number', '!=', null)->with(['user', 'gateway'])->where('status','!=',0)->latest()->paginate(getPaginate(1));
        return view('admin.payment.log', compact('page_title', 'empty_message', 'deposits'));
    }

    public function paymentViaMethod($method,$type = null){
        $method = Gateway::where('alias',$method)->firstOrFail();

        if ($type == 'approved') {
            $page_title = 'Approved Payment Via '.$method->name;
            $deposits = Deposit::where('order_number', '!=', null)->where('method_code','>=',1000)->where('method_code',$method->code)->where('status', 1)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        }elseif($type == 'rejected'){
            $page_title = 'Rejected Payment Via '.$method->name;
            $deposits = Deposit::where('order_number', '!=', null)->where('method_code','>=',1000)->where('method_code',$method->code)->where('status', 3)->latest()->with(['user', 'gateway'])->paginate(getPaginate());

        }elseif($type == 'successful'){
            $page_title = 'Successful Payment Via '.$method->name;
            $deposits = Deposit::where('order_number', '!=', null)->where('status', 1)->where('method_code',$method->code)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        }elseif($type == 'pending'){
            $page_title = 'Pending Payment Via '.$method->name;
            $deposits = Deposit::where('order_number', '!=', null)->where('method_code','>=',1000)->where('method_code',$method->code)->where('status', 2)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        }else{
            $page_title = 'Payment Via '.$method->name;
            $deposits = Deposit::where('order_number', '!=', null)->where('status','!=',0)->where('method_code',$method->code)->latest()->with(['user', 'gateway'])->paginate(getPaginate());
        }
        $methodAlias = $method->alias;
        $empty_message = 'Payment Log';
        return view('admin.payment.log', compact('page_title', 'empty_message', 'deposits','methodAlias'));
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $page_title = '';
        $empty_message = 'No search result was found.';
        $deposits = Deposit::where('order_number', '!=', null)->with(['user', 'gateway'])->where('status','!=',0)->where(function ($q) use ($search) {
            $q->where('trx', 'like', "%$search%")->orWhereHas('user', function ($user) use ($search) {
                $user->where('username', 'like', "%$search%");
            });
        });
        switch ($scope) {
            case 'pending':
                $page_title .= 'Pending Deposits Search';
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 2);
                break;
            case 'approved':
                $page_title .= 'Approved Deposits Search';
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 1);
                break;
            case 'rejected':
                $page_title .= 'Rejected Deposits Search';
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 3);
                break;
            case 'list':
                $page_title .= 'Payment History Search';
                break;
        }

        $deposits = $deposits->paginate(getPaginate());
        $page_title .= ' - ' . $search;

        return view('admin.payment.log', compact('page_title', 'search', 'scope', 'empty_message', 'deposits'));
    }

    public function dateSearch(Request $request,$scope = null){

        $search = $request->date;
        if (!$search) {
            return back();
        }
        $date = explode('-',$search);
        $start = @$date[0];
        $end = @$date[1];

        if(!(@strtotime($date[0]) && @strtotime($date[1]))){
            $notify[]=['error','Please provide valid date'];
            return back()->withNotify($notify);
        }

        if ($start) {
            $deposits = Deposit::where('order_number', '!=', null)->where('status','!=',0)->where('created_at','>',Carbon::parse($start)->subDays(1))->where('created_at','<=',Carbon::parse($start)->addDays(1));
        }
        if($end){
            $deposits = Deposit::where('order_number', '!=', null)->where('status','!=',0)->where('created_at','>',Carbon::parse($start)->subDays(1))->where('created_at','<',Carbon::parse($end)->addDays(1));
        }
        if ($request->method) {
            $method = Gateway::where('alias',$request->method)->firstOrFail();
            $deposits = $deposits->where('method_code',$method->code);
        }
        switch ($scope) {
            case 'pending':
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 2);
                break;
            case 'approved':
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 1);
                break;
            case 'rejected':
                $deposits = $deposits->where('method_code', '>=', 1000)->where('status', 3);
                break;
        }
        $deposits = $deposits->with(['user', 'gateway'])->latest()->paginate(getPaginate());
        $page_title = ' Payment Log';
        $empty_message = 'Payment Not Found';
        $dateSearch = $search;
        return view('admin.payment.log', compact('page_title', 'empty_message', 'deposits','dateSearch','scope'));
    }

    public function details($id)
    {
        $general = GeneralSetting::first();
        $deposit = Deposit::where('id', $id)->where('order_number', '!=', null)->where('method_code', '>=', 1000)->with(['user', 'gateway'])->firstOrFail();
        $page_title = $deposit->user->username.' requested ' . getAmount($deposit->amount) . ' '.$general->cur_text;
        $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;

        $orders = Sell::where('user_id',$deposit->user->id)->where('status',0)->get();
        $empty_message = 'No data found';
        return view('admin.payment.detail', compact('page_title', 'deposit','details','orders'));
    }


    public function approve(Request $request)
    {

        $request->validate(['id' => 'required|integer']);
        $deposit = Deposit::where('id',$request->id)->where('order_number', '!=', null)->where('status',2)->firstOrFail();
        $deposit->status = 1;
        $deposit->save();
        $gnl = GeneralSetting::first();

        $sells = Sell::where('user_id',$deposit->user->id)->where('status',0)->get();

        foreach ($sells as $item) {
            $item->status = 1;
            $item->save();

            $item->product->total_sell += 1;
            $item->product->save();

            $levels = Level::get();
            $author = $item->author;
            $author->earning = $author->earning + ($item->total_price - ($item->product->category->buyer_fee + (($item->total_price * $author->levell->product_charge) / 100)));
            $author->balance += $item->total_price;

            if (($author->earning >= $author->levell->earning) && ($author->earning < $levels->max('earning'))) {
                $author->level_id += 1;
            }

            $authorTransaction = new Transaction();
            $authorTransaction->user_id = $author->id;
            $authorTransaction->amount = $item->total_price;
            $authorTransaction->post_balance = $author->balance;
            $authorTransaction->charge = 0;
            $authorTransaction->trx_type = '+';
            $authorTransaction->details = getAmount($authorTransaction->amount) . ' ' . $gnl->cur_text .' Added with Balance For selling a product named ' .$item->product->name;
            $authorTransaction->trx =  getTrx();
            $authorTransaction->save();

            $author->balance = $author->balance - ($item->product->category->buyer_fee + (($item->total_price * $author->levell->product_charge) / 100));
            $author->save();

            $authorTransaction = new Transaction();
            $authorTransaction->user_id = $author->id;
            $authorTransaction->amount = $item->product->category->buyer_fee + (($item->total_price * $author->levell->product_charge) / 100);
            $authorTransaction->post_balance = $author->balance;
            $authorTransaction->charge = 0;
            $authorTransaction->trx_type = '-';
            $authorTransaction->details = $item->product->category->buyer_fee + (($item->total_price * $author->levell->product_charge) / 100) . ' ' . $gnl->cur_text .' Charged For selling a product named ' .$item->product->name;
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
                'product_amount' => getAmount($item->product_price),
                'support_fee' => getAmount($item->support_fee),
                'support_time' => $item->support_time ? $item->support_time : 'No support',
                'trx' => $authorTransaction->trx,
                'purchase_code' => $item->code,
                'post_balance' => getAmount($author->balance),
                'buyer_fee' => $author->levell->product_charge,
                'amount' => $item->total_price - ($item->product->category->buyer_fee + (($item->total_price * $author->levell->product_charge) / 100))
            ]);
        }

        $user = User::find($deposit->user_id);

        $user->balance += $deposit->amount;

        $transaction = new Transaction();
        $transaction->user_id = $deposit->user_id;
        $transaction->amount = $deposit->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $deposit->charge;
        $transaction->trx_type = '+';
        $transaction->details = 'Payment Via ' . $deposit->gateway_currency()->name;
        $transaction->trx = $deposit->trx;
        $transaction->save();

        $user->balance -= $deposit->amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $deposit->user_id;
        $transaction->amount = $deposit->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $deposit->charge;
        $transaction->trx_type = '-';
        $transaction->details = getAmount($deposit->amount) . ' ' . $gnl->cur_text .' Subtracted From Your Balance For Purchasing Products.';
        $transaction->trx = $deposit->trx;
        $transaction->save();

        $productList = '';

        foreach ($sells as $item) {
            $productList .= '# '.$item->product->name.'<br>';
        }

        notify($user, 'PAYMENT_APPROVE', [
            'method_name' => $deposit->gateway_currency()->name,
            'method_currency' => $deposit->method_currency,
            'method_amount' => getAmount($deposit->final_amo),
            'amount' => getAmount($deposit->amount),
            'charge' => getAmount($deposit->charge),
            'currency' => $gnl->cur_text,
            'rate' => getAmount($deposit->rate),
            'trx' => $deposit->trx,
            'post_balance' => getAmount($user->balance)
        ]);

        notify($user, 'PRODUCT_PURCHASED', [
            'method_name' => $deposit->gateway_currency()->name,
            'currency' => $gnl->cur_text,
            'total_amount' => getAmount($deposit->amount),
            'post_balance' => $user->balance,
            'product_list' => $productList
        ]);

        $notify[] = ['success', 'Payment has been approved.'];

        return redirect()->route('admin.payment.pending')->withNotify($notify);
    }

    public function reject(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'message' => 'required|max:250'
        ]);

        $deposit = Deposit::where('id',$request->id)->where('order_number', '!=', null)->where('status',2)->firstOrFail();

        $deposit->admin_feedback = $request->message;
        $deposit->status = 3;
        $deposit->save();

        $sells = Sell::where('user_id',$deposit->user->id)->where('status',0)->get();

        foreach ($sells as $item) {
            $item->status = 2;
            $item->reject_message = $request->message;
            $item->save();
        }

        $gnl = GeneralSetting::first();

        notify($deposit->user, 'PAYMENT_REJECT', [
            'method_name' => $deposit->gateway_currency()->name,
            'method_currency' => $deposit->method_currency,
            'method_amount' => getAmount($deposit->final_amo),
            'amount' => getAmount($deposit->amount),
            'charge' => getAmount($deposit->charge),
            'currency' => $gnl->cur_text,
            'rate' => getAmount($deposit->rate),
            'trx' => $deposit->trx,
            'rejection_message' => $request->message
        ]);

        $notify[] = ['success', 'Payment has been rejected.'];
        return  redirect()->route('admin.payment.pending')->withNotify($notify);
    }
}
