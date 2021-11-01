<?php

namespace App\Http\Controllers\Auth;

use App\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\UserLogin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('regStatus')->except('registrationNotAllowed');

        $this->activeTemplate = activeTemplate();
    }

    public function referralRegister($reference)
    {
        $page_title = "Sign Up";
        session()->put('reference', $reference);
        $info = json_decode(json_encode(getIpInfo()), true);
        $country_code = @implode(',', $info['code']);
        return view($this->activeTemplate . 'user.auth.register', compact('reference', 'page_title','country_code'));
    }

    public function showRegistrationForm()
    {
        $page_title = "Sign Up";
        $info = json_decode(json_encode(getIpInfo()), true);
        $country_code = @implode(',', $info['code']);
        return view($this->activeTemplate . 'user.auth.register', compact('page_title','country_code'));
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
            'email' => 'required|string|email|max:90|unique:users',
            'mobile' => 'required|string|max:50|unique:users',
            'password' => 'required|string|min:6|max:255|confirmed',
            'username' => 'required|alpha_num|unique:users|min:6|max:50',
            'captcha' => 'sometimes|required',
            'country_code' => 'required'
        ]);

        return $validate;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $exist = User::where('mobile',$request->country_code.$request->mobile)->first();

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

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $gnl = GeneralSetting::first();


        $referBy = session()->get('reference');
        if ($referBy != null) {
            $referUser = User::where('username', $referBy)->first();
        } else {
            $referUser = null;
        }

        //User Create
        $user = new User();
        $user->firstname = isset($data['firstname']) ? $data['firstname'] : null;
        $user->lastname = isset($data['lastname']) ? $data['lastname'] : null;
        $user->email = strtolower(trim($data['email']));
        $user->level_id = 1;
        $user->password = Hash::make($data['password']);
        $user->username = trim($data['username']);
        $user->ref_by = ($referUser != null) ? $referUser->id : null;
        $user->mobile = $data['country_code'].$data['mobile'];
        $user->address = [
            'address' => '',
            'state' => '',
            'zip' => '',
            'country' => isset($data['country']) ? $data['country'] : null,
            'city' => ''
        ];
        $user->status = 1;
        $user->ev = $gnl->ev ? 0 : 1;
        $user->sv = $gnl->sv ? 0 : 1;
        $user->ts = 0;
        $user->tv = 1;
        $user->save();



        //Login Log Create
        $ip = $_SERVER["REMOTE_ADDR"];
        $exist = UserLogin::where('user_ip',$ip)->first();
        $userLogin = new UserLogin();

        //Check exist or not
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->location =  $exist->location;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        }else{
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude =  @implode(',',$info['long']);
            $userLogin->latitude =  @implode(',',$info['lat']);
            $userLogin->location =  @implode(',',$info['city']) . (" - ". @implode(',',$info['area']) ."- ") . @implode(',',$info['country']) . (" - ". @implode(',',$info['code']) . " ");
            $userLogin->country_code = @implode(',',$info['code']);
            $userLogin->country =  @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();


        return $user;
    }

    public function registered()
    {
        return redirect()->route('user.home');
    }

}
