<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Reviewer;
use App\ReviewerLogin;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageReviewersController extends Controller
{
    public function allReviewers()
    {
        $page_title = 'All Reviewer';
        $empty_message = 'No reviewer found';
        $reviewers = Reviewer::latest()->paginate(getPaginate());
        return view('admin.reviewer.list', compact('page_title', 'empty_message', 'reviewers'));
    }

    public function activeReviewers()
    {
        $page_title = 'Active Reviewer';
        $empty_message = 'No active reviewer found';
        $reviewers = Reviewer::active()->latest()->paginate(getPaginate());
        return view('admin.reviewer.list', compact('page_title', 'empty_message', 'reviewers'));
    }

    public function bannedReviewers()
    {
        $page_title = 'Banned Reviewer';
        $empty_message = 'No banned reviewer found';
        $reviewers = Reviewer::banned()->latest()->paginate(getPaginate());
        return view('admin.reviewer.list', compact('page_title', 'empty_message', 'reviewers'));
    }

    public function emailUnverifiedReviewers()
    {
        $page_title = 'Email Unverified Reviewer';
        $empty_message = 'No email unverified reviewer found';
        $reviewers = Reviewer::emailUnverified()->latest()->paginate(getPaginate());
        return view('admin.reviewer.list', compact('page_title', 'empty_message', 'reviewers'));
    }

    public function emailVerifiedReviewers()
    {
        $page_title = 'Email Verified Reviewer';
        $empty_message = 'No email verified reviewer found';
        $reviewers = Reviewer::emailVerified()->latest()->paginate(getPaginate());
        return view('admin.reviewer.list', compact('page_title', 'empty_message', 'reviewers'));
    }

    public function smsUnverifiedReviewers()
    {
        $page_title = 'SMS Unverified Reviewer';
        $empty_message = 'No sms unverified reviewer found';
        $reviewers = Reviewer::smsUnverified()->latest()->paginate(getPaginate());
        return view('admin.reviewer.list', compact('page_title', 'empty_message', 'reviewers'));
    }

    public function smsVerifiedReviewers()
    {
        $page_title = 'SMS Verified Reviewer';
        $empty_message = 'No sms verified reviewer found';
        $reviewers = Reviewer::smsVerified()->latest()->paginate(getPaginate());
        return view('admin.reviewer.list', compact('page_title', 'empty_message', 'reviewers'));
    }

    public function newReviewer()
    {
        $page_title = 'Add New Reviewer';
        return view('admin.reviewer.new', compact('page_title'));
    }

    public function storeReviewer(Request $request){

        $request->validate([
            'image' => [new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'firstname' => 'sometimes|required|string|max:50',
            'lastname' => 'sometimes|required|string|max:50',
            'email' => 'required|string|email|max:90|unique:reviewers',
            'mobile' => 'required|string|max:50|unique:reviewers',
            'password' => 'required|string|min:6|max:255|confirmed',
            'username' => 'required|alpha_num|unique:reviewers|min:6|max:50',
        ]);

        $reviewer_image = '';
        if($request->hasFile('image')) {
            try{

                $location = imagePath()['profile']['reviewer']['path'];
                $size = imagePath()['profile']['reviewer']['size'];

                $reviewer_image = uploadImage($request->image, $location , $size);

            }catch(\Exception $exp) {
                return back()->withNotify(['error', 'Could not upload the image.']);
            }
        }

        $reviewer = new Reviewer();
        $reviewer->image = $reviewer_image;
        $reviewer->firstname = $request->firstname;
        $reviewer->lastname = $request->lastname;
        $reviewer->email = $request->email;
        $reviewer->mobile = $request->mobile;
        $reviewer->password = Hash::make($request->password);
        $reviewer->username = $request->username;
        $reviewer->address = [
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
        ];
        $reviewer->save();

        notify($reviewer, 'REVIEWER_CREDENTIALS', [
            'username' => $reviewer->username,
            'password' => $request->password,
        ]);

        $notify[] = ['success', 'Reviewer details has been added'];
        return back()->withNotify($notify);
    }

    public function detail($id)
    {
        $page_title = 'Reviewer Detail';

        $reviewer = Reviewer::findOrFail($id);

    //     $new_appointment = Appointment::where('staff',$reviewer->id)->where('try',1)->where('d_status',0)->where('is_complete',0)->whereHas('relationStaff', function ($query) {
    //         $query->where('status',1);
    //     })->count();

    //     $appointment_done = Appointment::where('staff',$reviewer->id)->where('try',1)->where('is_complete',1)->where('p_status',1)->where('d_status',0)->latest()->whereHas('relationStaff', function ($query) {
    //         $query->where('status',1);
    //    })->count();

    //     $total_appointment = Appointment::where('staff',$reviewer->id)->where('try',1)->where('d_status',0)->latest()->where('is_complete',0)->whereHas('relationStaff', function ($query) {
    //         $query->where('status',1);
    //    })->count();

        return view('admin.reviewer.detail', compact('page_title', 'reviewer'));
    }

    public function update(Request $request, $id)
    {
        $reviewer = Reviewer::findOrFail($id);

        $request->validate([
            'firstname' => 'sometimes|required|string|max:50',
            'lastname' => 'sometimes|required|string|max:50',
            'email' => 'required|string|email|max:90|unique:reviewers,email,' . $reviewer->id,
            'mobile' => 'required|string|max:50|unique:reviewers,mobile,' . $reviewer->id,
        ]);

        if ($request->email != $reviewer->email && Reviewer::whereEmail($request->email)->whereId('!=', $reviewer->id)->count() > 0) {
            $notify[] = ['error', 'Email already exists.'];
            return back()->withNotify($notify);
        }

        if ($request->mobile != $reviewer->mobile && Reviewer::where('mobile', $request->mobile)->whereId('!=', $reviewer->id)->count() > 0) {
            $notify[] = ['error', 'Mobile number already exists.'];
            return back()->withNotify($notify);
        }


        $reviewer->mobile = $request->mobile;
        $reviewer->firstname = $request->firstname;
        $reviewer->lastname = $request->lastname;
        $reviewer->email = $request->email;
        $reviewer->address = [
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
        ];
        $reviewer->status = $request->status ? 1 : 0;
        $reviewer->ev = $request->ev ? 1 : 0;
        $reviewer->sv = $request->sv ? 1 : 0;
        $reviewer->tv = $request->tv ? 1 : 0;
        $reviewer->ts = $request->ts ? 1 : 0;
        $reviewer->save();

        $notify[] = ['success', 'Reviewer detail has been updated'];
        return redirect()->back()->withNotify($notify);
    }

    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $reviewers = Reviewer::where(function ($reviewers) use ($search) {
            $reviewers->where('username', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('mobile', 'like', "%$search%");
        });
        $page_title = '';
        switch ($scope) {
            case 'active':
                $page_title .= 'Active ';
                $reviewers = $reviewers->where('status', 1);
                break;
            case 'banned':
                $page_title .= 'Banned';
                $reviewers = $reviewers->where('status', 0);
                break;
            case 'emailUnverified':
                $page_title .= 'Email Unerified ';
                $reviewers = $reviewers->where('ev', 0);
                break;
            case 'smsUnverified':
                $page_title .= 'SMS Unverified ';
                $reviewers = $reviewers->where('sv', 0);
                break;
        }
        $reviewers = $reviewers->paginate(getPaginate());
        $page_title .= 'Reviewer Search - ' . $search;
        $empty_message = 'No search result found';
        return view('admin.reviewer.list', compact('page_title', 'search', 'scope', 'empty_message', 'reviewers'));
    }

    public function reviewerLoginHistory($id)
    {
        $reviewer = Reviewer::findOrFail($id);
        $page_title = 'Reviewer Login History - ' . $reviewer->username;
        $empty_message = 'No reviewer login found.';
        $login_logs = $reviewer->login_logs()->latest()->paginate(getPaginate());
        return view('admin.reviewer.logins', compact('page_title', 'empty_message', 'login_logs'));
    }

    public function loginHistory(Request $request)
    {
        if ($request->search) {
            $search = $request->search;
            $page_title = 'Reviewer Login History Search - ' . $search;
            $empty_message = 'No search result found.';
            $login_logs = ReviewerLogin::whereHas('reviewer', function ($query) use ($search) {
                $query->where('username', $search);
            })->latest()->paginate(getPaginate());
            return view('admin.reviewer.logins', compact('page_title', 'empty_message', 'search', 'login_logs'));
        }
        $page_title = 'Reviewer Login History';
        $empty_message = 'No reviewer login found.';
        $login_logs = ReviewerLogin::latest()->paginate(getPaginate());
        return view('admin.reviewer.logins', compact('page_title', 'empty_message', 'login_logs'));
    }

    public function loginIpHistory($ip)
    {
        $page_title = 'Login By - ' . $ip;
        $login_logs = ReviewerLogin::where('reviewer_ip',$ip)->latest()->paginate(getPaginate());
        $empty_message = 'No reviewer login found.';
        return view('admin.reviewer.logins', compact('page_title', 'empty_message', 'login_logs'));

    }

    public function showEmailSingleForm($id)
    {
        $reviewer = Reviewer::findOrFail($id);
        $page_title = 'Send Email To: ' . $reviewer->username;
        return view('admin.reviewer.email_single', compact('page_title', 'reviewer'));
    }

    public function sendEmailSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        $reviewer = Reviewer::findOrFail($id);
        send_general_email($reviewer->email, $request->subject, $request->message, $reviewer->username);
        $notify[] = ['success', $reviewer->username . ' will receive an email shortly.'];
        return back()->withNotify($notify);
    }

    public function showEmailAllForm()
    {
        $page_title = 'Send Email To All Reviewers';
        return view('admin.reviewer.email_all', compact('page_title'));
    }

    public function sendEmailAll(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        foreach (Reviewer::where('status', 1)->cursor() as $reviewer) {
            send_general_email($reviewer->email, $request->subject, $request->message, $reviewer->username);
        }

        $notify[] = ['success', 'All Reviewers will receive an email shortly.'];
        return back()->withNotify($notify);
    }
}
