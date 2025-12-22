<?php

namespace App\Http\Controllers;

use App\Helpers\AndroidCommonHelper;
use App\Helpers\ResponseHelper;
use App\Helpers\WhatsAppSend;
use Illuminate\Http\Request;
use App\User;
use App\Models\Pindata;
use App\Models\Api;
use App\Models\Circle;
use App\Models\Company;
use App\Models\DeleteAccount;
use App\Models\Role;
use App\Models\LoanEnquiry;
use App\Models\PortalSetting;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\JwtGenerator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public  function __construct()
    {
        if (!Auth::check()) {

            return redirect('login');
        }
    }

    public function deleteAccount(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'remark' => 'required'
        ]);

        // Create a new instance of your model and fill it with validated data
        $newRecord = new DeleteAccount();
        $newRecord->name = $validatedData['name'];
        $newRecord->mobile = $validatedData['mobile'];
        $newRecord->email = $validatedData['email'];
        $newRecord->remark = $validatedData['remark'];

        // Save the record to the database
        $newRecord->save();

        Storage::disk('local')->put('public/safexPaylink.txt', 'decryptedResponse:' . json_encode($request));
        // Optionally, you can return a response indicating success
        return response()->json(['status' => 'SUCCESS', 'message' => 'Delete Account Request Submitted Successfully'], 200);
        // return ResponseHelper::success('Delete Account Request Submitted Successfully');

    }

    public function adminLogin(Request $post)
    {
        $data['state'] = Circle::all();
        $data['roles'] = Role::whereIn('slug', ['whitelable', 'md', 'distributor', 'retailer'])->get();
        $string = substr(str_shuffle("ABCDEFGHJKHLMKOPRTEST"), 17);
        $data['cptcha'] = $string . rand(11, 99);
        //  return view('welcome')->with($data);
        $data['company'] = Company::where('website', $_SERVER['HTTP_HOST'])->first();
        return view('login')->with($data);
    }

    public function login(Request $post)
    {

        if (!empty($request['g-recaptcha-response'])) {
            $Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . env('re_Captcha_SecretKey') . "&response={$request['g-recaptcha-response']}");
            $Return = json_decode($Response);
            if ($Return->success == false) {
                return response()->json(['status' => "Your are a robot"], 400);
            }
        }

        $user = User::where('mobile', $post->mobile)->first();

        $url = $_SERVER['HTTP_REFERER'];
        $QueryUrl = parse_url($url);

        $urlObject = (object) $QueryUrl;
        $getAdmin = trim($urlObject->path, "/");
        $checkAdmin = substr($getAdmin, 0, strpos($getAdmin, '/'));

        $user = User::where('mobile', $post->mobile)->first();

        if (!$user) {
            return response()->json(['status' => "Your aren't registred with us."], 400);
        }

        //  if($checkAdmin <> "admin" && $user->role_id =="1"){
        //   return response()->json(['status' => "Admin Login not allowed in this url" ], 400);
        // }elseif($checkAdmin == "admin" && $user->role_id !="1"){
        //     return response()->json(['status' => "User Login not allowed in this url" ], 400);
        // }
        //   $geodata = geoip($post->ip());
        $log['ip'] = $post->ip();
        $log['user_agent'] = $post->server('HTTP_USER_AGENT');
        $log['user_id'] = $user->id;
        $log['geo_location'] = $post->latitude . "/" . $post->longitude;
        $log['url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $log['parameters'] = 'portal';


        $att['user_id'] = $user->id;
        $att['geo_location'] = $post->latitude . "/" . $post->longitude;

        \DB::table('login_activitylogs')->insert($log);
        \DB::table('attendance')->insert($att);
        $company = Company::where('id', $user->company_id)->first();
        $otprequired = PortalSetting::where('code', 'otplogin')->first();

        if (!\Auth::validate(['mobile' => $post->mobile, 'password' => $post->password])) {
            return response()->json(['status' => 'Username or password is incorrect'], 400);
        }

        if (!\Auth::validate(['mobile' => $post->mobile, 'password' => $post->password, 'status' => "active"])) {
            return response()->json(['status' => 'Your account currently de-activated, please contact administrator'], 400);
        }


        if ($otprequired->value == "yes" && $company->senderid) {
            if ($post->has('otp') && $post->otp == "resend") {
                if ($user->otpresend < 3) {
                    $otpmailid = \App\Models\PortalSetting::where('code', 'otpsendmailid')->first();
                    $otpmailname = \App\Models\PortalSetting::where('code', 'otpsendmailname')->first();

                    $otp = rand(111111, 999999);
                    $arr = ["mobile" => $post->mobile, "var2" => $otp];
                    $send = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);

                    $mail = \Myhelper::mail('mail.otp', ["otp" => $otp, "name" => $user->name, "subhead" => "Login OTP"], $user->email, $user->name, $otpmailid->value, $otpmailname->value, "Login Otp");
                    if ($send['status'] == true || $mail == "success") {
                        User::where('mobile', $post->mobile)->update(['otpverify' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678"), 'otpresend' => $user->otpresend + 1]);
                        return response()->json(['status' => 'otpsent'], 200);
                    } else {
                        return response()->json(['status' => 'Please contact your service provider provider'], 400);
                    }
                } else {
                    return response()->json(['status' => 'Otp resend limit exceed, please contact your service provider'], 400);
                }
            }

            if ($user->otpverify == "yes" || !$post->has('otp')) {
                $otp = rand(111111, 999999);
                $arr = ["mobile" => $post->mobile, "var2" => $otp];
                $send = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);

                $otpmailid = \App\Models\PortalSetting::where('code', 'otpsendmailid')->first();
                $otpmailname = \App\Models\PortalSetting::where('code', 'otpsendmailname')->first();
                $mail = \Myhelper::mail('mail.otp', ["otp" => $otp, "name" => $user->name, "subhead" => "Login OTP"], $user->email, $user->name, $otpmailid->value, $otpmailname->value, "Login Otp");
                if ($send['status'] == true || $mail == "success") {
                    User::where('mobile', $post->mobile)->update(['otpverify' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678")]);
                    return response()->json(['status' => 'otpsent'], 200);
                } else {
                    return response()->json(['status' => 'Please contact your service provider provider'], 400);
                }
            } else {
                if (!$post->has('otp')) {
                    return response()->json(['status' => 'preotp'], 200);
                }
            }

            if (\Auth::attempt(['mobile' => $post->mobile, 'password' => $post->password, 'otpverify' => \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"), 'status' => "active"])) {
                return response()->json(['status' => 'Login'], 200);
            } else {
                return response()->json(['status' => 'Please provide correct otp'], 400);
            }
        } else {
            if (\Auth::attempt(['mobile' => $post->mobile, 'password' => $post->password, 'status' => "active"])) {
                return response()->json(['status' => 'Login'], 200);
            } else {
                return response()->json(['status' => 'Something went wrong, please contact administrator'], 400);
            }
        }
    }

    public function logout(Request $request)
    {

        $user = \Auth::user();

        if ($user) {
            $userId = $user->id;

            \DB::table('attendance')->where('user_id', $userId)->whereNull('logout_time')->update(['logout_time' => now()->toDateTimeString()]);
        }

        \Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    public function passwordReset(Request $post)
    {

        $rules = array(
            'type' => 'required',
            'mobile' => 'required|numeric',
        );

        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }


        if ($post->type == "request") {
            $user = \App\User::where('mobile', $post->mobile)->first();
            if ($user) {
                $otp = rand(111111, 999999);

                $arr = ["mobile" => $post->mobile, "var2" => $otp];
                $sms = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);


                $otpmailid = \App\Models\PortalSetting::where('code', 'otpsendmailid')->first();
                $otpmailname = \App\Models\PortalSetting::where('code', 'otpsendmailname')->first();
                try {
                    $mail = \Myhelper::mail('mail.password', ["token" => $otp, "name" => $user->name, "subhead" => "Reset Password"], $user->email, $user->name, $otpmailid->value, $otpmailname->value, "Reset Password");
                } catch (\Exception $e) {
                    $mail = "fail";


                    // return response()->json(['status' => 'ERR', 'message' => "Something went wrong1"], 400);
                }
                //dd($sms);
                if ($sms['status'] || $mail) {
                    User::where('mobile', $post->mobile)->update(['remember_token' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678")]);
                    return response()->json(['status' => 'TXN', 'message' => "Password reset token sent successfully"], 200);
                } else {
                    return response()->json(['status' => 'ERR', 'message' => "Something went wrong2"], 400);
                }
            } else {
                return response()->json(['status' => 'ERR', 'message' => "You aren't registered with us"], 400);
            }
        } else {
            $user = User::where('mobile', $post->mobile)->where('remember_token', \Myhelper::encrypt($post->token, "sdsada7657hgfh$$&7678"))->get();
            if ($user->count() == 1) {
                $update = User::where('mobile', $post->mobile)->update(['password' => bcrypt($post->password)]);
                if ($update) {
                    return response()->json(['status' => "TXN", 'message' => "Password reset successfully"], 200);
                } else {
                    return response()->json(['status' => 'ERR', 'message' => "Something went wrong"], 400);
                }
            } else {
                return response()->json(['status' => 'ERR', 'message' => "Please enter valid token"], 400);
            }
        }
    }

    public function getotp(Request $post)
    {
        // dd($post->all());
        $rules = array(
            'mobile' => 'required|numeric'
        );

        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }
        $otpmailid = \App\Models\PortalSetting::where('code', 'otpsendmailid')->first();
        $otpmailname = \App\Models\PortalSetting::where('code', 'otpsendmailname')->first();
        $user = \App\User::where('mobile', $post->mobile)->first();
        if ($user) {
            $otp = rand(111111, 999999);

            $arr = ["mobile" => $post->mobile, "var2" => $otp];
            $sms = AndroidCommonHelper::sendEmailAndOtp("sendOtp", $arr);

            try {
                $mail = \Myhelper::mail('mail.otp', ["otp" => $otp, "name" => $user->name, "subhead" => "Reset TPIN"], $user->email, $user->name, $otpmailid->value, $otpmailname->value, "Reset TPIN");
            } catch (\Exception $e) {
                // dd($e) ;
                $mail = "fail";
            }
            if ($mail == "success" || $sms['status'] == true) {
                $user = \DB::table('password_resets')->insert([
                    'mobile' => $post->mobile,
                    'token' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678"),
                    'last_activity' => time()
                ]);

                return response()->json(['status' => 'TXN', 'message' => "Pin generate token sent successfully"], 200);
            } else {
                return response()->json(['status' => 'ERR', 'message' => "Something went wrong"], 400);
            }
        } else {
            return response()->json(['status' => 'ERR', 'message' => "You aren't registered with us"], 400);
        }
    }

    public function setpin(Request $post)
    {
        //dd(\Myhelper::encrypt($post->otp, "a6e028f0c683"));
        $rules = array(
            'id' => 'required|numeric',
            'otp' => 'required|numeric',
            'pin' => 'required|numeric|confirmed',
        );

        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }

        $user = \DB::table('password_resets')->where('mobile', $post->mobile)->where('token', \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"))->first();
        if ($user) {
            try {
                Pindata::where('user_id', $post->id)->delete();
                $apptoken = Pindata::create([
                    'pin' => \Myhelper::encrypt($post->pin, "sdsada7657hgfh$$&7678"),
                    'user_id' => $post->id
                ]);
            } catch (\Exception $e) {
                return response()->json(['status' => 'ERR', 'message' => 'Try Again']);
            }

            if ($apptoken) {
                \DB::table('password_resets')->where('mobile', $post->mobile)->where('token', \Myhelper::encrypt($post->otp, "sdsada7657hgfh$$&7678"))->delete();
                return response()->json(['status' => "success"], 200);
            } else {
                return response()->json(['status' => "Something went wrong"], 400);
            }
        } else {
            return response()->json(['status' => "Please enter valid otp"], 400);
        }
    }

    public function registration(Request $post)
    {
        $rules = array(
            'name' => 'required',
            'mobile' => 'required|numeric|digits:10|unique:users,mobile',
            'email' => 'required|email|unique:users,email',
            // 'shopname' => 'required|unique:users,shopname',
            // 'pancard' => 'required|unique:users,pancard',
            // 'aadharcard' => 'required|numeric|unique:users,aadharcard|digits:12',
            // 'state' => 'required',
            // 'city' => 'required',
            'address' => 'required',
            // 'pincode' => 'required|digits:6|numeric',
            'slug' => ['required', Rule::In(['student', 'teacher'])]
        );

        $validate = \Myhelper::FormValidator($rules, $post);
        if ($validate != "no") {
            return $validate;
        }

        $admin = User::whereHas('role', function ($q) {
            $q->where('slug', 'admin');
        })->first(['id', 'company_id']);
        $password = $post->mobile; //  \Myhelper::generateiv(16);
        $role = Role::where('slug', $post->slug)->first();

        $post['role_id'] = $role->id;
        $post['id'] = $post->id;
        $post['parent_id'] = 1;
        $post['passwordold'] = bcrypt($password);
        $post['password'] = bcrypt($password);
        $post['company_id'] = $admin->company_id;
        $post['agentcode'] = date('ymdhis');
        // $post['status'] = "pending";
        // $post['blockby_admin'] = "yes";
        // $post['kyc'] = "pending";

        $scheme = \DB::table('default_permissions')->where('type', 'scheme')->where('role_id', $role->id)->first();
        if ($scheme) {
            $post['scheme_id'] = 3;
        }

        $response = User::updateOrCreate(['id' => $post->id], $post->all());
        if ($response) {
            $permissions = \DB::table('default_permissions')->where('type', 'permission')->where('role_id', $post->role_id)->get();
            if (sizeof($permissions) > 0) {
                foreach ($permissions as $permission) {
                    $insert = array('user_id' => $response->id, 'permission_id' => $permission->permission_id);
                    $inserts[] = $insert;
                }
                \DB::table('user_permissions')->insert($inserts);
            }

            $arr = ["mobile" => $post->mobile, "var2" => $post->mobile, "var3" => $post->mobile];
            $sms = AndroidCommonHelper::sendEmailAndOtp("activateAccount", $arr);

            return response()->json(['status' => "TXN", 'message' => "Success"], 200);
        } else {
            return response()->json(['status' => 'ERR', 'message' => "Something went wrong, please try again"], 400);
        }
    }

    public function loanformstore(Request $post)
    {

        $post['user_id'] = \Auth::id();
        $response = LoanEnquiry::create($post->all());
        if ($response) {
            return response()->json(['status' => "TXN", 'message' => "Success"], 200);
        } else {
            return response()->json(['status' => 'ERR', 'message' => "Something went wrong, please try again"], 400);
        }
    }



    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'nullable|numeric|digits:10'
        ]);

        $otpmailid = PortalSetting::where('code', 'otpsendmailid')->first();
        $otpmailname = PortalSetting::where('code', 'otpsendmailname')->first();
        $phone = $request->mobile;
        $mobile = $request->mobile;

        $user = User::where('mobile', $mobile)->first();
        $userExists = $user ? true : false;

        $otp = rand(1111, 9999);
        // $otp = '1234';

        $sms = AndroidCommonHelper::sendEmailAndOtp("sendOtp", [
            "mobile" => $mobile,
            "var2" => $otp
        ]);
        if ($userExists) {
            try {
                $mail = \Myhelper::mail(
                    'mail.otp',
                    ["otp" => $otp, "name" => $user->name, "subhead" => "Reset TPIN"],
                    $user->email,
                    $user->name,
                    $otpmailid->value,
                    $otpmailname->value,
                    "Reset TPIN"
                );
            } catch (\Exception $e) {
                $mail = "fail";
            }
        } else {
            $mail = "fail";
        }

        if ($mail == "success" || ($sms['status'] ?? false)) {
            \DB::table('password_resets')->updateOrInsert(
                ['mobile' => $phone],
                [
                    'token' => \Myhelper::encrypt($otp, "sdsada7657hgfh$$&7678"),
                    'last_activity' => time()
                ]
            );

            return response()->json([
                'status' => 'TXN',
                'message' => 'OTP sent successfully',
                'exists' => $userExists
            ], 200);
        } else {
            return response()->json(['status' => 'ERR', 'message' => "Something went wrong"], 400);
        }
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits:10',
            'otp'   => 'required|digits:4'
        ]);

        $record = \DB::table('password_resets')
            ->where('mobile', $request->phone)
            ->first();

        if (!$record) {
            return response()->json(['status' => 'ERR', 'message' => 'OTP not found. Please request a new one.'], 400);
        }

        $storedOtp = \Myhelper::decrypt($record->token, "sdsada7657hgfh$$&7678");

        if ($storedOtp != $request->otp) {
            return response()->json(['status' => 'ERR', 'message' => 'Incorrect OTP'], 400);
        }

        $expiry = 5 * 60;
        if (time() - $record->last_activity > $expiry) {
            return response()->json(['status' => 'ERR', 'message' => 'OTP expired. Please request a new one.'], 400);
        }

        \DB::table('password_resets')->where('mobile', $request->phone)->delete();

        $user = User::where('mobile', $request->phone)->first();
        $userExists = $user ? true : false;

        if ($userExists) {
            Auth::login($user);
        }

        return response()->json([
            'status' => 'TXN',
            'message' => 'OTP verified successfully',
            'exists' => $userExists,
            'user' => $userExists ? $user : null
        ], 200);
    }



    public function saveStep(Request $request)
    {
        $validate = $request->validate([
            'phone' => 'required|numeric|digits:10',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'qualification' => 'required|string|max:255',
            'interest' => 'required|string|max:255',
        ]);

        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email already exists',
            ], 422);
        }

        $user = User::where('mobile', $request->phone)->first();
        $agentcode = date('ymdhis');

        if ($user) {
            Auth::login($user);
            $message = 'Logged in successfully';
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'agentcode' => $agentcode,
                'mobile' => $request->phone,
                'role_id' => 2,
                'parent_id' => 1,
                'company_id' => 1,
                'highest_qualification' => $request->qualification,
                'area_of_interest' => $request->interest,
                'password' => bcrypt($request->phone),
                'whatsapp_updates' => ($request->updates === 'true') ? 'yes' : 'no',
            ]);

            Auth::login($user);
            $message = 'User created and logged in successfully';
        }
        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }


    public function completeSignup(Request $request)
    {
        $request->validate([
            'interested_course' => 'required|string|max:255',
            'enroll_plan' => 'required|string|max:255',
            'career_advice' => 'required|string|max:255',
            'work_experience' => 'required|string|max:255',
            'callback_date' => 'required|date_format:Y-m-d H:i'
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ]);
        }

        $userId = $user->id;
        $userToUpdate = User::find($userId);

        if (!$userToUpdate) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }

        $userToUpdate->update([
            'interested_course' => $request->interested_course,
            'enroll_plan' => $request->enroll_plan,
            'career_advice' => $request->career_advice,
            'work_experience' => $request->work_experience,
            'callback_date' => $request->callback_date,

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Signup completed successfully',
            'redirect_url' => url('/')
        ]);
    }
}
