<?php
namespace App\Http\Controllers;
use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function LoginPage()
    {
        return view('pages.login-page');
    }

    public function VerifyPage()
    {
        return view('pages.verify-page');
    }


    public function UserLogin(string $UserEmail):JsonResponse
    {
        try {
            // $UserEmail=$request->UserEmail;
            $OTP=rand (100000,999999);
            $details = ['code' => $OTP];
               Mail::to($UserEmail)->queue(new OTPMail($details));

            // Mail::to($UserEmail)->send(new OTPMail($details));//Mail::to()Sends it to receiver's email using SMTP,Mail:: is laravel mailing system , OTPMail is custom , command(php artisan make:mail OTPMail)
            User::updateOrCreate(['email' => $UserEmail], ['email'=>$UserEmail,'otp'=>$OTP]);
            return ResponseHelper::Out('success',"A 6 Digit OTP has been send to your email address",200);
        } catch (Exception $e) {
            return ResponseHelper::Out('fail',$e,200);
        }
    }


public function VerifyLogin(string $UserEmail, string $OTP): JsonResponse
{
    $user = User::where('email', $UserEmail)
                ->where('otp', $OTP)
                ->first();

    if ($user) {
        // Clear the OTP
        $user->otp = '0'; // or null
        $user->save();

        // Create JWT token
        $token = JWTToken::CreateToken($user->email, $user->id, $user->role);

        // Return success with cookie
        return ResponseHelper::Out('success', "", 200)
                             ->cookie('token', $token, 60 * 24 * 1); // 1 day
    }

    return ResponseHelper::Out('fail', null, 401);
}


    function UserLogout(){
        return redirect('/')->cookie('token','',-1);
    }

    public function index() {
        $data = [];
        $users = User::latest('id')->paginate();
    $data['users'] = $users;
        return view('admin.layouts.userlist', $data);
    }
}

