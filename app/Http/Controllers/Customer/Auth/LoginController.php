<?php

namespace App\Http\Controllers\Customer\Auth;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\Wishlist;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Str;
use function App\CPU\translate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\CPU\SMS_module;
use App\Model\PhoneOrEmailVerification;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Laravel\Passport\HasApiTokens;
use App\Model\CustomerWallet;

class LoginController extends Controller
{
    public $company_name;

    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
    }


    public function login()
    {
        session()->put('keep_return_url', url()->previous());
        return view('customer-view.auth.login');
    }


    public function submit(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|required|in:' . User::all()->pluck('phone')->implode(',') . ','
        ]);

        $se = User::where(['phone' => $request['phone']])->first();

        if (isset($se) && $se['is_active'] == 1) {

            Session::put("user.phone", $request->phone);

            $this->whatsapp($request);
            return $this->login_phone_verify();

        } elseif (isset($se) && $se['status'] == 'pending') {
            return redirect()->back()->withInput($request->only('phone'))
                ->withErrors(['Your account is not approved yet.']);
        } elseif (isset($se) && $se['status'] == 'suspended') {
            return redirect()->back()->withInput($request->only('phone'))
                ->withErrors(['Your account has been suspended!.']);
        }
        return redirect()->back()->withInput($request->only('phone'))
            ->withErrors(['This number is not Registered .']);
        
    }

    public function whatsapp($request)
    {
        $token = '1111';
        $this->token = $token;

        $sender = "967777794438";
        $dest = "967" . $request->phone;
        $massagestouser1 = " حياك الله في امــداد، تفضل رمز الدخول: ";
        $isiPesan = $massagestouser1 . "" . $token . "";


        Session::put("user.token", $token);

        // masukan data pengiriman pesan ke log
        $curl = curl_init();
        $data = [
            'number' => $sender, // number sender
            'message' => $isiPesan, // message content
            'to' => $dest, // number receiver
        ];

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, 'https://api.stiker-label.com/send');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        // dd($result);

    }

    public function login_phone_verify()
    {
        if(Session::get("user.phone")){
            return view('customer-view.auth.login-phone-verify');
        }
        return redirect()->route("register");
    }


    public function login_submit_phone_token(Request $request)
    {
        $token = $request->digit_1 . $request->digit_2 . $request->digit_3 . $request->digit_4;
        $token_  =   Session::get("user.token");
        $phone  =   Session::get("user.phone");
        $seller = User::where("phone", $phone)->first();


        if ($token == $token_) {
            if(Auth::guard('customer')->login($seller)){
                Toastr::info('Welcome to your dashboard!');
                if (CustomerWallet::where('customer_id', auth('customer')->id())->first() == false) {
                    DB::table('customer_wallets')->insert([
                        'customer_id' => auth('customer')->id(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            return redirect()->route('customer.locations');
        } else {
            Toastr::error('verification number is wrong');
            return redirect()->route('customer.login.phone.verify');
        }
    }


 

    public function logout(Request $request)
    {
        auth()->guard('customer')->logout();
        session()->forget('wish_list');
        Toastr::info('Come back soon, ' . '!');
        return redirect()->route('home');
    }
}
