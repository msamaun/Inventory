<?php

namespace App\Http\Controllers;

use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function UserRegistration(Request $request)
    {
        try{
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'mobile' => 'required|max:20',
                'password' => 'required|string'
            ]);

            User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' =>Hash::make( $request->input('password')),
            ]);

            return Response()->json(['status' => 'success', 'message' => 'User Registration Successfully']);

        }
        catch (Exception $e){
            return Response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }

    }


    function UserLogin(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]);

            $user =user::where('email',$request->input('email'))->first();
            if(!$user || !Hash::check($request->input('password'), $user->password))
            {
                return Response()->json(['status' => 'fail', 'message' => 'Invalid Email or Password']);
            }
            $token = $user->createToken('authToken')->plainTextToken;
            return Response()->json(['status' => 'success', 'message' => 'User Login Successfully', 'token' => $token]);

        }
        catch (Exception $e){
            return Response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }

    }

    function UserProfile()
    {
        return Auth::user();
    }

    function UserLogout(Request $request)
    {
       $request->user()->tokens()->delete();
        return redirect('/user-login');
    }

    function UserUpdate(Request $request)
    {
        try{
           $request->validate([
               'first_name' => 'required|string|max:255',
               'last_name' => 'required|string|max:255',
               'mobile' => 'required|max:20',
           ]);

           User::where('id', Auth::user()->id)->update([
               'first_name' => $request->input('first_name'),
               'last_name' => $request->input('last_name'),
               'mobile' => $request->input('mobile'),
           ]);

           return Response()->json(['status' => 'success', 'message' => 'User Update Successfully']);
        }
        catch (Exception $e){
            return Response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    function SendOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
            ]);
            $email = $request->input('email');
            $otp = rand(1000, 9999);
            $count = User::where('email', $email)->count();

            if($count==1){
                Mail::to($email)->send(new OTPMail($otp));
                User::where('email','=', $email)->update(['otp' => $otp]);
                return Response()->json(['status' => 'success', 'message' => 'OTP Send Successfully']);
            }
            else{
                return Response()->json(['status' => 'fail', 'message' => 'User Not Found']);
            }
        }
        catch (Exception $e){
            return Response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }

    function VerifyOtp(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|string|email',
                'otp' => 'required|string|min:4'
            ]);

            $email = $request->input('email');
            $otp = $request->input('otp');

            $user =User::where('email','=',$email)->where('otp', '=', $otp)->first();

            if(!$user){
                return Response()->json(['status' => 'fail', 'message' => 'Invalid OTP']);
            }
            User::where('email','=', $email)->update(['otp' => 0]);
            $token = $user->createToken('authToken')->plainTextToken;
            return Response()->json(['status' => 'success', 'message' => 'OTP Verify Successfully', 'token' => $token]);
        }
        catch (Exception $e){
            return Response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


    function ResetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string',
            ]);
            $id = Auth::id();
            $password = $request->input('password');
            User::where('id', '=', $id)->update(['password' => Hash::make($password)]);
            return Response()->json(['status' => 'success', 'message' => 'Password Reset Successfully']);
        } catch (Exception $e) {
            return Response()->json(['status' => 'fail', 'message' => $e->getMessage()]);
        }
    }


}
