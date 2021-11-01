<?php

namespace App\Http\Controllers\Reviewer\Auth;

use App\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Reviewer;
use App\ReviewerLogin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/reviewer/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('reviewer.guest');
        $this->middleware('reviewerRegStatus');
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */

    public function showRegistrationForm()
    {
        $page_title = "Sign Up";
        $info = json_decode(json_encode(getIpInfo()), true);
        $country_code = @implode(',', $info['code']);
        return view('reviewer.auth.register', compact('page_title','country_code'));
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validate = Validator::make($data, [
            'firstname' => 'sometimes|required|string|max:50',
            'lastname' => 'sometimes|required|string|max:50',
            'email' => 'required|string|email|max:90|unique:reviewers',
            'mobile' => 'required|string|max:50|unique:reviewers',
            'password' => 'required|string|min:6|max:255|confirmed',
            'username' => 'required|alpha_num|unique:reviewers|min:6|max:50',
            'captcha' => 'sometimes|required',
            'country_code' => 'required'
        ]);

        return $validate;
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $exist = reviewer::where('mobile',$request->country_code.$request->mobile)->first();
        if ($exist) {
            $notify[] = ['error', 'Mobile number already exist'];
            return back()->withNotify($notify)->withInput();
        }

        if (isset($request->captcha)) {
            if (!captchaVerify($request->captcha, $request->captcha_secret)) {
                $notify[] = ['error', "Invalid Captcha"];
                return back()->withNotify($notify)->withInput();
            }
        }

        event(new Registered($reviewer = $this->create($request->all())));

        $this->guard()->login($reviewer);

        return $this->registered($request, $reviewer)
            ?: redirect($this->redirectPath());

    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\reviewer
     */
    protected function create(array $data)
    {

        $gnl = GeneralSetting::first();


        $referBy = session()->get('reference');
        if ($referBy != null) {
            $referreviewer = reviewer::where('username', $referBy)->first();
        } else {
            $referreviewer = null;
        }

        //User Create
        $reviewer = new reviewer();
        $reviewer->firstname = isset($data['firstname']) ? $data['firstname'] : null;
        $reviewer->lastname = isset($data['lastname']) ? $data['lastname'] : null;
        $reviewer->email = strtolower(trim($data['email']));
        $reviewer->password = Hash::make($data['password']);
        $reviewer->username = trim($data['username']);
        $reviewer->ref_by = ($referreviewer != null) ? $referreviewer->id : null;
        $reviewer->mobile = $data['country_code'].$data['mobile'];
        $reviewer->address = [
            'address' => '',
            'state' => '',
            'zip' => '',
            'country' => isset($data['country']) ? $data['country'] : null,
            'city' => ''
        ];
        $reviewer->status = 1;
        $reviewer->ev = $gnl->ev ? 0 : 1;
        $reviewer->sv = $gnl->sv ? 0 : 1;
        $reviewer->ts = 0;
        $reviewer->tv = 1;
        $reviewer->save();



        //Login Log Create
        $ip = $_SERVER["REMOTE_ADDR"];
        $exist = reviewerLogin::where('reviewer_ip',$ip)->first();
        $reviewerLogin = new reviewerLogin();

        //Check exist or not
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


        return $reviewer;
    }

        /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */

    protected function guard()
    {
        return Auth::guard('reviewer');
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $reviewer
     * @return mixed
     */

    public function registered()
    {
        return redirect()->route('reviewer.dashboard');
    }

}
