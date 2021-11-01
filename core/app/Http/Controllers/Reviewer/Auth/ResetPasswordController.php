<?php

namespace App\Http\Controllers\Reviewer\Auth;

use App\Reviewer;
use App\ReviewerPasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;


class ResetPasswordController extends Controller
{
    /*
        |--------------------------------------------------------------------------
        | Password Reset Controller
        |--------------------------------------------------------------------------
        |
        | This controller is responsible for handling password reset requests
        | and uses a simple trait to include this behavior. You're free to
        | explore this trait and override any methods you wish to tweak.
        |
        */

    use ResetsPasswords;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/reviewer/dashboard';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('reviewer.guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token)
    {
        $page_title = "Account Recovery";
        $tk = ReviewerPasswordReset::where('token', $token)->where('status', 0)->first();

        if (empty($tk)) {
            $notify[] = ['error', 'Token Not Found!'];
            return redirect()->route('reviewer.password.reset')->withNotify($notify);
        }
        $email = $tk->email;
        return view('reviewer.auth.passwords.reset', compact('page_title', 'email', 'token'));
    }


    public function reset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:4',
        ]);

        $reset = ReviewerPasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        $reviewer = Reviewer::where('email', $reset->email)->first();
        if ($reset->status == 1) {
            $notify[] = ['error', 'Invalid code'];
            return redirect()->route('reviewer.login')->withNotify($notify);
        }

        $reviewer->password = bcrypt($request->password);
        $reviewer->save();
        ReviewerPasswordReset::where('email', $reviewer->email)->update(['status' => 1]);

        $reviewerAgent = getIpInfo();
        $osBrowser = osBrowser();
        notify($reviewer, 'PASS_RESET_DONE', [
            'operating_system' => @$osBrowser['os_platform'],
            'browser' => @$osBrowser['browser'],
            'ip' => @$reviewerAgent['ip'],
            'time' => @$reviewerAgent['time']
        ]);

        $notify[] = ['success', 'Password Changed'];
        return redirect()->route('reviewer.login')->withNotify($notify);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('reviewers');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('reviewer');
    }
}
