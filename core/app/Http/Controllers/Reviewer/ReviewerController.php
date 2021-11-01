<?php

namespace App\Http\Controllers\Reviewer;

use App\Answer;
use App\Category;
use App\Deposit;
use App\GeneralSetting;
use App\Lib\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use App\Option;
use App\Product;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\FileTypeValidate;
use App\Survey;
use App\TempProduct;
use App\Transaction;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use PDF;

class ReviewerController extends Controller
{
    public function dashboard()
    {

        $page_title = 'Dashboard';
        $totalPending = Product::where('status',0)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->count();
        $totalApproved =  Product::where('status',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->count();
        $totalSoft =  Product::where('status',2)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->count();
        $totalHard =  Product::where('status',3)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->count();
        $totalUpdatePending = TempProduct::where('type',2)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->count();
        $totalResubmitted = TempProduct::where('type',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->count();

        return   view('reviewer.dashboard',compact('page_title','totalPending','totalApproved','totalSoft','totalHard','totalUpdatePending','totalResubmitted'));
    }

    public function profile()
    {
        $page_title = 'Profile';
        $reviewer = Auth::guard('reviewer')->user();
        return view('reviewer.profile', compact('page_title', 'reviewer'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => "sometimes|required|max:80",
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
        ],[
            'firstname.required'=>'First Name Field is required',
            'lastname.required'=>'Last Name Field is required'
        ]);

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
            'city' => $request->city,
        ];

        $reviewer = Auth::guard('reviewer')->user();

        $reviewer_image = $reviewer->image;
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['profile']['reviewer']['path'];
                $size = imagePath()['profile']['reviewer']['size'];
                $old = $reviewer->image;
                $reviewer_image = uploadImage($request->image, $location , $size, $old);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $in['image'] = $reviewer_image;
        $reviewer->fill($in)->save();

        $notify[] = ['success', 'Your profile has been updated.'];
        return redirect()->route('reviewer.profile')->withNotify($notify);
    }

    public function password()
    {
        $page_title = 'Password Setting';
        $reviewer = Auth::guard('reviewer')->user();
        return view('reviewer.password', compact('page_title', 'reviewer'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $reviewer = Auth::guard('reviewer')->user();
        if (!Hash::check($request->old_password, $reviewer->password)) {
            $notify[] = ['error', 'Password Do not match !!'];
            return back()->withErrors(['Invalid old password.']);
        }

        $reviewer->update([
            'password' => Hash::make($request->password),
        ]);

        $notify[] = ['success', 'Password Changed Successfully.'];
        return redirect()->route('reviewer.password')->withNotify($notify);
    }

    public function show2faForm()
    {
        $gnl = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $reviewer = Auth::guard('reviewer')->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($reviewer->username . '@' . $gnl->sitename, $secret);
        $prevcode = $reviewer->tsc;
        $prevqr = $ga->getQRCodeGoogleUrl($reviewer->username . '@' . $gnl->sitename, $prevcode);
        $page_title = 'Two Factor';
        return view('reviewer.twofactor', compact('page_title', 'secret', 'qrCodeUrl', 'prevcode', 'prevqr'));
    }

    public function create2fa(Request $request)
    {
        $reviewer = Auth::guard('reviewer')->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);

        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);

        if ($oneCode === $request->code) {
            $reviewer->tsc = $request->key;
            $reviewer->ts = 1;
            $reviewer->tv = 1;
            $reviewer->save();


            $reviewerAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($reviewer, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$reviewerAgent['ip'],
                'time' => @$reviewerAgent['time']
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

        $reviewer = Auth::guard('reviewer')->user();
        $ga = new GoogleAuthenticator();

        $secret = $reviewer->tsc;
        $oneCode = $ga->getCode($secret);
        $reviewerCode = $request->code;

        if ($oneCode == $reviewerCode) {

            $reviewer->tsc = null;
            $reviewer->ts = 0;
            $reviewer->tv = 1;
            $reviewer->save();


            $reviewerAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($reviewer, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$reviewerAgent['ip'],
                'time' => @$reviewerAgent['time']
            ]);


            $notify[] = ['success', 'Two Factor Authenticator Disable Successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->withNotify($notify);
        }
    }

    public function pending()
    {
        $page_title = 'Pending Products';
        $empty_message = 'No data found';

        $products = Product::where('status',0)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->latest()->with(['category','subcategory'])->paginate(getPaginate());

        return view('reviewer.product.index',compact('page_title','products','empty_message'));
    }

    public function approved()
    {
        $page_title = 'Approved Products';
        $empty_message = 'No data found';

        $products = Product::where('status',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->latest()->with(['category','subcategory'])->paginate(getPaginate());

        return view('reviewer.product.index',compact('page_title','products','empty_message'));
    }

    public function softRejected()
    {
        $page_title = 'Soft Rejected Products';
        $empty_message = 'No data found';

        $products = Product::where('status',2)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->latest()->with(['category','subcategory'])->paginate(getPaginate());

        return view('reviewer.product.index',compact('page_title','products','empty_message'));
    }

    public function hardRejected()
    {
        $page_title = 'Hard Rejected Products';
        $empty_message = 'No data found';

        $products = Product::where('status',3)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->latest()->with(['category','subcategory'])->paginate(getPaginate());

        return view('reviewer.product.index',compact('page_title','products','empty_message'));
    }

    public function download($id)
    {
        $product = Product::findOrFail(Crypt::decrypt($id));

        $file = $product->file;
        $full_path = 'assets/product/' . $file;
        $title = str_replace(' ','_',strtolower($product->name));
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($full_path);
        header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }

    public function view($id)
    {
        $product = Product::whereHas('user', function ($query) {
            $query->where('status',1);
        })->findOrFail(Crypt::decrypt($id));
        $page_title = 'Product : '.$product->name;

        return view('reviewer.product.view',compact('page_title','product'));
    }

    public function approveProduct(Request $request){
        $request->validate([
            'id' => 'required|gt:0',
        ]);

        $product = Product::whereHas('user', function ($query) {
            $query->where('status',1);
        })->findOrFail($request->id);
        $product->status = 1;
        $product->save();

        notify($product->user, 'PRODUCT_APPROVED', [
            'product_name' => $product->name
        ]);

        $notify[] = ['success', 'Product has been approved successfully'];
        return back()->withNotify($notify);
    }

    public function softRejectProduct(Request $request){

        $request->validate([
            'id' => 'required|gt:0',
            'message' => 'required',
        ]);

        $product = Product::whereHas('user', function ($query) {
            $query->where('status',1);
        })->findOrFail($request->id);
        $product->status = 2;
        $product->soft_reject = $request->message;
        $product->save();

        notify($product->user, 'PRODUCT_SOFT_REJECT', [
            'product_name' => $product->name,
            'rejection_message' => $product->soft_reject,
        ]);

        $notify[] = ['success', 'Product has been soft rejected successfully'];
        return back()->withNotify($notify);
    }

    public function hardRejectProduct(Request $request){
        $request->validate([
            'id' => 'required|gt:0',
            'message' => 'required',
        ]);

        $product = Product::whereHas('user', function ($query) {
            $query->where('status',1);
        })->findOrFail($request->id);
        $product->status = 3;
        $product->hard_reject = $request->message;
        $product->save();

        notify($product->user, 'PRODUCT_HARD_REJECT', [
            'product_name' => $product->name
        ]);

        $notify[] = ['success', 'Product has been rejected successfully'];
        return back()->withNotify($notify);
    }

    public function updatePending()
    {
        $page_title = 'Update Pending Products';
        $empty_message = 'No data found';

        $products = TempProduct::where('type',2)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->latest()->paginate(getPaginate());

        return view('reviewer.product.index',compact('page_title','products','empty_message'));
    }

    public function updatePendingView($id)
    {
        $product = TempProduct::where('type',2)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->findOrFail(Crypt::decrypt($id));
        $page_title = 'Product : '.$product->name;

        return view('reviewer.product.view',compact('page_title','product'));
    }

    public function updatePendingDownload($id)
    {
        $product = TempProduct::where('type',2)->findOrFail(Crypt::decrypt($id));

        if ($product->file) {
            $file = $product->file;
            $full_path = 'assets/temp_product/' . $file;
            $title = str_replace(' ','_',strtolower($product->name));
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $mimetype = mime_content_type($full_path);
            header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
            header("Content-Type: " . $mimetype);
            return readfile($full_path);
        }else{
            $notify[] = ['error', 'This product has no file update'];
            return back()->withNotify($notify);
        }
    }

    public function updatePendingApprove(Request $request)
    {
        $request->validate([
            'id' => 'required|gt:0',
        ]);

        $tempProduct = TempProduct::where('type',2)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->findOrFail($request->id);

        $mainProduct = Product::where('id',$tempProduct->product_id)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->first();


        if($tempProduct->image){
            $tempProductLocation = imagePath()['temp_p_image']['path'];
            $mainProductLocation = imagePath()['p_image']['path'];

            removeFile($mainProductLocation . '/' . $mainProduct->image);
            removeFile($mainProductLocation . '/thumb_' . $mainProduct->image);
            rename($tempProductLocation . '/' . $tempProduct->image, $mainProductLocation . '/' . $tempProduct->image);
            rename($tempProductLocation . '/thumb_' . $tempProduct->image, $mainProductLocation . '/thumb_' . $tempProduct->image);

            $mainProduct->image = $tempProduct->image;
        }

        if($tempProduct->file){
            $tempProductLocation = imagePath()['temp_p_file']['path'];
            $mainProductLocation = imagePath()['p_file']['path'];

            removeFile($mainProductLocation . '/' . $mainProduct->file);
            rename($tempProductLocation . '/' . $tempProduct->file, $mainProductLocation . '/' . $tempProduct->file);

            $mainProduct->file = $tempProduct->file;
        }

        if($tempProduct->screenshot){
            $tempProductLocation = imagePath()['temp_p_screenshot']['path'];
            $mainProductLocation = imagePath()['p_screenshot']['path'];

            foreach ($mainProduct->screenshot as $item) {
                removeFile($mainProductLocation . '/' . $item);
            }

            foreach ($tempProduct->screenshot as $item) {
                rename($tempProductLocation . '/' . $item, $mainProductLocation . '/' . $item);
            }

            $pScreenshot = $tempProduct->screenshot;
        }else{
            $pScreenshot = $mainProduct->screenshot;
        }

        $mainProduct->update_status = 2;
        $mainProduct->regular_price = $tempProduct->regular_price;
        $mainProduct->extended_price = $tempProduct->extended_price;
        $mainProduct->support = $tempProduct->support;
        $mainProduct->support_charge = $tempProduct->support_charge;
        $mainProduct->support_discount = $tempProduct->support_discount;
        $mainProduct->name = $tempProduct->name;
        $mainProduct->screenshot = $pScreenshot;
        $mainProduct->demo_link = $tempProduct->demo_link;
        $mainProduct->description = $tempProduct->description;
        $mainProduct->tag = $tempProduct->tag;
        $mainProduct->message = $tempProduct->message;
        $mainProduct->category_details = $tempProduct->category_details;
        $mainProduct->save();

        $tempProduct->delete();

        notify($mainProduct->user, 'PRODUCT_UPDATE_APPROVED', [
            'product_name' => $mainProduct->name
        ]);

        $notify[] = ['success', 'Update of this product has been approved successfully'];
        return redirect()->route('reviewer.dashboard')->withNotify($notify);
    }

    public function updatePendingReject(Request $request)
    {
        $request->validate([
            'id' => 'required|gt:0',
            'message' => 'required'
        ]);

        $tempProduct = TempProduct::where('type',2)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->findOrFail($request->id);

        $mainProduct = Product::where('id',$tempProduct->product_id)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->first();

        $mainProduct->update_status = 3;
        $mainProduct->update_reject = $request->message;
        $mainProduct->save();

        if($tempProduct->image){

            $tempProductLocation = imagePath()['temp_p_image']['path'];
            removeFile($tempProductLocation . '/' . $tempProduct->image);
            removeFile($tempProductLocation . '/thumb_' . $tempProduct->image);
        }

        if($tempProduct->file){

            $tempProductLocation = imagePath()['temp_p_file']['path'];
            removeFile($tempProductLocation . '/' . $tempProduct->file);
        }

        if($tempProduct->screenshot){

            $tempProductLocation = imagePath()['temp_p_screenshot']['path'];

            foreach ($tempProduct->screenshot as $item) {
                removeFile($tempProductLocation . '/' . $item);
            }
        }

        $tempProduct->delete();

        notify($mainProduct->user, 'PRODUCT_UPDATE_REJECTED', [
            'product_name' => $mainProduct->name
        ]);

        $notify[] = ['success', 'Update of this product has been rejected successfully'];
        return redirect()->route('reviewer.dashboard')->withNotify($notify);
    }

    public function resubmit()
    {
        $page_title = 'Resubmitted Products';
        $empty_message = 'No data found';

        $products = TempProduct::where('type',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->latest()->paginate(getPaginate());

        return view('reviewer.product.index',compact('page_title','products','empty_message'));
    }

    public function resubmitView($id)
    {
        $product = TempProduct::where('type',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->findOrFail(Crypt::decrypt($id));
        $page_title = 'Product : '.$product->name;

        return view('reviewer.product.view',compact('page_title','product'));
    }

    public function resubmitDownload($id)
    {
        $product = TempProduct::where('type',1)->findOrFail(Crypt::decrypt($id));

        if ($product->file) {

            $file = $product->file;
            $full_path = 'assets/temp_product/' . $file;
            $title = str_replace(' ','_',strtolower($product->name));
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $mimetype = mime_content_type($full_path);
            header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
            header("Content-Type: " . $mimetype);
            return readfile($full_path);
        }else{
            $notify[] = ['error', 'This product has no file update'];
            return back()->withNotify($notify);
        }

    }

    public function resubmitApprove(Request $request)
    {
        $request->validate([
            'id' => 'required|gt:0',
        ]);

        $tempProduct = TempProduct::where('type',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->findOrFail($request->id);

        $mainProduct = Product::where('id',$tempProduct->product_id)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->first();


        if($tempProduct->image){
            $tempProductLocation = imagePath()['temp_p_image']['path'];
            $mainProductLocation = imagePath()['p_image']['path'];

            removeFile($mainProductLocation . '/' . $mainProduct->image);
            removeFile($mainProductLocation . '/thumb_' . $mainProduct->image);
            rename($tempProductLocation . '/' . $tempProduct->image, $mainProductLocation . '/' . $tempProduct->image);
            rename($tempProductLocation . '/thumb_' . $tempProduct->image, $mainProductLocation . '/thumb_' . $tempProduct->image);

            $mainProduct->image = $tempProduct->image;
        }

        if($tempProduct->file){
            $tempProductLocation = imagePath()['temp_p_file']['path'];
            $mainProductLocation = imagePath()['p_file']['path'];

            removeFile($mainProductLocation . '/' . $mainProduct->file);
            rename($tempProductLocation . '/' . $tempProduct->file, $mainProductLocation . '/' . $tempProduct->file);

            $mainProduct->file = $tempProduct->file;
        }

        if($tempProduct->screenshot){
            $tempProductLocation = imagePath()['temp_p_screenshot']['path'];
            $mainProductLocation = imagePath()['p_screenshot']['path'];

            foreach ($mainProduct->screenshot as $item) {
                removeFile($mainProductLocation . '/' . $item);
            }

            foreach ($tempProduct->screenshot as $item) {
                rename($tempProductLocation . '/' . $item, $mainProductLocation . '/' . $item);
            }

            $pScreenshot = $tempProduct->screenshot;
        }else{
            $pScreenshot = $mainProduct->screenshot;
        }

        $mainProduct->status = 1;
        $mainProduct->regular_price = $tempProduct->regular_price;
        $mainProduct->extended_price = $tempProduct->extended_price;
        $mainProduct->support = $tempProduct->support;
        $mainProduct->support_charge = $tempProduct->support_charge;
        $mainProduct->support_discount = $tempProduct->support_discount;
        $mainProduct->name = $tempProduct->name;
        $mainProduct->screenshot = $pScreenshot;
        $mainProduct->demo_link = $tempProduct->demo_link;
        $mainProduct->description = $tempProduct->description;
        $mainProduct->tag = $tempProduct->tag;
        $mainProduct->message = $tempProduct->message;
        $mainProduct->category_details = $tempProduct->category_details;
        $mainProduct->save();

        $tempProduct->delete();

        notify($mainProduct->user, 'PRODUCT_APPROVED', [
            'product_name' => $mainProduct->name
        ]);

        $notify[] = ['success', 'Resubmisssion of this product has been approved successfully'];
        return redirect()->route('reviewer.dashboard')->withNotify($notify);
    }

    public function resubmitSoftReject(Request $request)
    {
        $request->validate([
            'id' => 'required|gt:0',
            'message' => 'required'
        ]);

        $tempProduct = TempProduct::where('type',1)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->findOrFail($request->id);

        $mainProduct = Product::where('id',$tempProduct->product_id)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->first();

        $mainProduct->status = 2;
        $mainProduct->soft_reject = $request->message;
        $mainProduct->save();

        if($tempProduct->image){

            $tempProductLocation = imagePath()['temp_p_image']['path'];
            removeFile($tempProductLocation . '/' . $tempProduct->image);
            removeFile($tempProductLocation . '/thumb_' . $tempProduct->image);
        }

        if($tempProduct->file){

            $tempProductLocation = imagePath()['temp_p_file']['path'];
            removeFile($tempProductLocation . '/' . $tempProduct->file);
        }

        if($tempProduct->screenshot){

            $tempProductLocation = imagePath()['temp_p_screenshot']['path'];

            foreach ($tempProduct->screenshot as $item) {
                removeFile($tempProductLocation . '/' . $item);
            }
        }

        $tempProduct->delete();

        notify($mainProduct->user, 'PRODUCT_SOFT_REJECT', [
            'product_name' => $mainProduct->name,
            'rejection_message' => $mainProduct->soft_reject,
        ]);

        $notify[] = ['success', 'Resubmission of this product has been softrejected successfully'];
        return redirect()->route('reviewer.dashboard')->withNotify($notify);
    }

    public function resubmitHardReject(Request $request)
    {
        $request->validate([
            'id' => 'required|gt:0',
            'message' => 'required'
        ]);

        $tempProduct = TempProduct::where('type',2)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->findOrFail($request->id);

        $mainProduct = Product::where('id',$tempProduct->product_id)->whereHas('user', function ($query) {
            $query->where('status',1);
        })->first();

        $mainProduct->status = 3;
        $mainProduct->hard_reject = $request->message;
        $mainProduct->save();

        if($tempProduct->image){

            $tempProductLocation = imagePath()['temp_p_image']['path'];
            removeFile($tempProductLocation . '/' . $tempProduct->image);
            removeFile($tempProductLocation . '/thumb_' . $tempProduct->image);
        }

        if($tempProduct->file){

            $tempProductLocation = imagePath()['temp_p_file']['path'];
            removeFile($tempProductLocation . '/' . $tempProduct->file);
        }

        if($tempProduct->screenshot){

            $tempProductLocation = imagePath()['temp_p_screenshot']['path'];

            foreach ($tempProduct->screenshot as $item) {
                removeFile($tempProductLocation . '/' . $item);
            }
        }

        $tempProduct->delete();

        notify($mainProduct->user, 'PRODUCT_HARD_REJECT', [
            'product_name' => $mainProduct->name
        ]);

        $notify[] = ['success', 'Resubmission of this product has been rejected successfully'];
        return redirect()->route('reviewer.dashboard')->withNotify($notify);
    }
}

