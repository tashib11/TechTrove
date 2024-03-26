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
    //
    public function UserLogin(Request $request):JsonResponse{

        try{
            $UserEmail=$request->UserEmail;
            $OTP=rand(100000,999999);
            $details=['code'=>$OTP];//associative array used a pair(strinf,value)
            try{
            Mail::to($UserEmail)->send(new OTPMail($details));
            }catch(Exception $e){
                return ResponseHelper::Out('otp fail',$e,401);
            }
            try{
            User::updateOrCreate(['email'=> $UserEmail],['email'=>$UserEmail,'otp'=>$OTP]);//built-in function for insert and update
            }catch(Exception $e){
                return ResponseHelper::Out('otp update fail',$e,401);
            }
    return ResponseHelper::Out('success',"A 6 digit OTP has been sent to your email address",200);
        }catch(Exception $e){
                      return ResponseHelper::Out('fail',$e,401);
        }
    }

    public function VerifyLogin(Request $request):JsonResponse{
        $UserEmail=$request->UserEmail;
        $OTP=$request->OTP;
        $verification=User::where('email',$UserEmail)->where('otp',$OTP)->first();
        if($verification){
            User::where('email',$UserEmail)->where('otp',$OTP)->update(['otp'=>'0']);
            $token=JWTToken::CreateToken($UserEmail,$verification->id);
            return ResponseHelper::Out('success',"",200)->cookie('token',$token,60*24*30);
        }else{
            return ResponseHelper::Out('fail',"",401);
        }
    }

    function UserLogout(){
        return redirect('/userLoginPage')->cookie('token','',-1);// cookie duration -1 mane coookie destroy hoye jawa
    }
 }
