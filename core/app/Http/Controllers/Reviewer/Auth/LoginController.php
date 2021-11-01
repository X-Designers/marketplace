<?php
namespace App\Http\Controllers\Reviewer\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\ReviewerLogin;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = 'reviewer';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('reviewer.guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $page_title = "Reviewer Login";
        return view('reviewer.auth.login', compact('page_title'));
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('reviewer');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);

        if(isset($request->captcha)){
            if(!captchaVerify($request->captcha, $request->captcha_secret)){
                $notify[] = ['error',"Invalid Captcha"];
                return back()->withNotify($notify)->withInput();
            }
        }

//

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {

        $customRecaptcha = \App\Extension::where('act', 'custom-captcha')->where('status', 1)->first();
        $validation_rule = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];

        if ($customRecaptcha) {
            $validation_rule['captcha'] = 'required';
        }

        $request->validate($validation_rule);

    }

    public function logout(Request $request)
    {
        $this->guard('reviewer')->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/reviewer');
    }

    public function resetPassword()
    {
        $page_title = 'reviewer Recovery';
        return view('reviewer.reset', compact('page_title'));
    }

    public function authenticated(Request $request, $reviewer)
    {
        if ($reviewer->status == 0) {
            $this->guard('reviewer')->logout();
            return redirect()->route('reviewer.login')->withErrors(['Your account has been deactivated.']);
        }

        $reviewer = auth()->guard('reviewer')->user();
        $reviewer->tv = $reviewer->ts == 1 ? 0 : 1;
        $reviewer->save();
        $ip = $_SERVER["REMOTE_ADDR"];
        $exist = ReviewerLogin::where('reviewer_ip',$ip)->first();
        $reviewerLogin = new ReviewerLogin();
        if ($exist) {
            $reviewerLogin->longitude =  $exist->longitude;
            $reviewerLogin->latitude =  $exist->latitude;
            $reviewerLogin->location =  $exist->location;
            $reviewerLogin->country_code = $exist->country_code;
            $reviewerLogin->country =  $exist->country;
        }else{
            $info = json_decode(json_encode(getIpInfo()), true);
            $reviewerLogin->longitude =  @implode(',',$info['long']);
            $reviewerLogin->latitude =  @implode(',',$info['lat']);
            $reviewerLogin->location =  @implode(',',$info['city']) . (" - ". @implode(',',$info['area']) ."- ") . @implode(',',$info['country']) . (" - ". @implode(',',$info['code']) . " ");
            $reviewerLogin->country_code = @implode(',',$info['code']);
            $reviewerLogin->country =  @implode(',', $info['country']);
        }

        $reviewerAgent = osBrowser();
        $reviewerLogin->reviewer_id = $reviewer->id;
        $reviewerLogin->reviewer_ip =  $ip;

        $reviewerLogin->browser = @$reviewerAgent['browser'];
        $reviewerLogin->os = @$reviewerAgent['os_platform'];
        $reviewerLogin->save();

        return redirect()->route('reviewer.dashboard');
    }
}
