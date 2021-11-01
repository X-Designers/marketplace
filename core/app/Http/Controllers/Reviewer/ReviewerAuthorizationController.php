<?php

namespace App\Http\Controllers\Reviewer;

use App\Lib\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ReviewerAuthorizationController extends Controller
{
    public function __construct()
    {
        return $this->activeTemplate = activeTemplate();
    }
    public function checkValidCode($reviewer, $code, $add_min = 10000)
    {
        if (!$code) return false;
        if (!$reviewer->ver_code_send_at) return false;
        if ($reviewer->ver_code_send_at->addMinutes($add_min) < Carbon::now()) return false;
        if ($reviewer->ver_code !== $code) return false;
        return true;
    }


    public function authorizeForm()
    {

        if (auth()->guard('reviewer')->check()) {
            $reviewer = Auth::guard('reviewer')->user();
            if (!$reviewer->status) {
                auth()->guard('reviewer')->logout();
            }elseif (!$reviewer->ev) {
                if (!$this->checkValidCode($reviewer, $reviewer->ver_code)) {
                    $reviewer->ver_code = verificationCode(6);
                    $reviewer->ver_code_send_at = Carbon::now();
                    $reviewer->save();
                    send_email($reviewer, 'EVER_CODE', [
                        'code' => $reviewer->ver_code
                    ]);
                }
                $page_title = 'Email verification form';
                return view('reviewer.auth.authorization.email', compact('reviewer', 'page_title'));
            }elseif (!$reviewer->sv) {
                if (!$this->checkValidCode($reviewer, $reviewer->ver_code)) {
                    $reviewer->ver_code = verificationCode(6);
                    $reviewer->ver_code_send_at = Carbon::now();
                    $reviewer->save();
                    send_sms($reviewer, 'SVER_CODE', [
                        'code' => $reviewer->ver_code
                    ]);
                }
                $page_title = 'SMS verification form';
                return view('reviewer.auth.authorization.sms', compact('reviewer', 'page_title'));
            }elseif (!$reviewer->tv) {
                $page_title = 'Google Authenticator';
                return view('reviewer.auth.authorization.2fa', compact('reviewer', 'page_title'));
            }else{
                return redirect()->route('reviewer.dashboard');
            }

        }

        return redirect()->route('reviewer.login');
    }

    public function sendVerifyCode(Request $request)
    {
        $reviewer = Auth::guard('reviewer')->user();


        if ($this->checkValidCode($reviewer, $reviewer->ver_code, 2)) {
            $target_time = $reviewer->ver_code_send_at->addMinutes(2)->timestamp;
            $delay = $target_time - time();
            throw ValidationException::withMessages(['resend' => 'Please Try after ' . $delay . ' Seconds']);
        }
        if (!$this->checkValidCode($reviewer, $reviewer->ver_code)) {
            $reviewer->ver_code = verificationCode(6);
            $reviewer->ver_code_send_at = Carbon::now();
            $reviewer->save();
        } else {
            $reviewer->ver_code = $reviewer->ver_code;
            $reviewer->ver_code_send_at = Carbon::now();
            $reviewer->save();
        }



        if ($request->type === 'email') {
            send_email($reviewer, 'EVER_CODE',[
                'code' => $reviewer->ver_code
            ]);

            $notify[] = ['success', 'Email verification code sent successfully'];
            return back()->withNotify($notify);
        } elseif ($request->type === 'phone') {
            send_sms($reviewer, 'SVER_CODE', [
                'code' => $reviewer->ver_code
            ]);
            $notify[] = ['success', 'SMS verification code sent successfully'];
            return back()->withNotify($notify);
        } else {
            throw ValidationException::withMessages(['resend' => 'Sending Failed']);
        }
    }

    public function emailVerification(Request $request)
    {
        $rules = [
            'email_verified_code.*' => 'required',
        ];
        $msg = [
            'email_verified_code.*.required' => 'Email verification code is required',
        ];
        $validate = $request->validate($rules, $msg);


        $email_verified_code =  str_replace(',','',implode(',',$request->email_verified_code));

        $reviewer = Auth::guard('reviewer')->user();

        if ($this->checkValidCode($reviewer, $email_verified_code)) {
            $reviewer->ev = 1;
            $reviewer->ver_code = null;
            $reviewer->ver_code_send_at = null;
            $reviewer->save();
            return redirect()->intended(route('reviewer.dashboard'));
        }
        throw ValidationException::withMessages(['email_verified_code' => 'Verification code didn\'t match!']);
    }

    public function smsVerification(Request $request)
    {
        $request->validate([
            'sms_verified_code.*' => 'required',
        ], [
            'sms_verified_code.*.required' => 'SMS verification code is required',
        ]);


        $sms_verified_code =  str_replace(',','',implode(',',$request->sms_verified_code));

        $reviewer = Auth::guard('reviewer')->user();
        if ($this->checkValidCode($reviewer, $sms_verified_code)) {
            $reviewer->sv = 1;
            $reviewer->ver_code = null;
            $reviewer->ver_code_send_at = null;
            $reviewer->save();
            return redirect()->intended(route('reviewer.dashboard'));
        }
        throw ValidationException::withMessages(['sms_verified_code' => 'Verification code didn\'t match!']);
    }
    public function g2faVerification(Request $request)
    {
        $reviewer = Auth::guard('reviewer')->user();

        $this->validate(
            $request, [
            'code.*' => 'required',
        ], [
            'code.*.required' => 'Code is required',
        ]);

        $ga = new GoogleAuthenticator();


        $code =  str_replace(',','',implode(',',$request->code));

        $secret = $reviewer->tsc;
        $oneCode = $ga->getCode($secret);
        $reviewerCode = $code;
        if ($oneCode == $reviewerCode) {
            $reviewer->tv = 1;
            $reviewer->save();
            return redirect()->route('reviewer.dashboard');
        } else {
            $notify[] = ['error', 'Wrong Verification Code'];
            return back()->withNotify($notify);
        }
    }

}
