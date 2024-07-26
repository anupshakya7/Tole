<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\PasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //Register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status'=>0,
            'password' => Hash::make($request->password)
        ]);
        $user->assignRole('user');
        \Avatar::create($request->name)->save(storage_path('app/public/avatar-' . $user->id . '.png'));

        $this->verifyMail($user);

        return response()->json([
            'message' => "User Register Successfully. Please Check your email for Verification",
            'user' => $user
        ]);
    }

    //Login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->filled('email')) {
            $user = User::where('email', $request->email)->where('status', 1)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is Inactive'
                ]);
            }
            $verify = User::where('email', $request->email)->whereNotNull('email_verified_at')->first();
            if (!$verify) {
                return response()->json([
                    'success' => false,
                    'message' => 'User must be Verified. Please check your email for the verification'
                ]);
            }
        }

        if (!$token = auth('api')->attempt($validator->validated())) {
            return response()->json([
                'success' => false,
                'message' => 'Username & Password is Incorrect'
            ]);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    //Forget Password
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain . '/reset-password?token=' . $token;

                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = 'Password Reset';
                $data['body'] = 'Please click on below link to reset your password.';

                Mail::send('emails.forgetPassword-email', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate([
                    'email' => $request->email
                ], [
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => $datetime
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Please check your mail to Reset your Password'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User Not Found'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    //Reset Password View Load
    public function resetPasswordLoad(Request $request)
    {
        $resetData = PasswordReset::where('token', $request->token)->first();
        if (isset($request->token) && !empty($resetData)) {
            $user = User::where('email', $resetData['email'])->first();
            return view('auth.forget-password.index', compact('user'));
        } else {
            echo "<h2>Not Found!!!</h2>";
        }
    }

    //Password Reset
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->save();

        PasswordReset::where('email', $user->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Your Password has been Reset Successfully!!!'
        ]);
    }

    //Logout
    public function logout()
    {
        try {
            auth('api')->logout();
            return response()->json([
                'success' => true,
                'message' => 'User Logout Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    //Verify Email
    public function verifyMail($user)
    {
        $random = Str::random(40);
        $domain = URL::to('/');
        $url = $domain . '/api/mail-verify/' . $random;

        $data['url'] = $url;
        $data['email'] = $user->email;
        $data['title'] = "Email Verification";
        $data['body'] = 'Please verify your email by clicking the link below.';

        Mail::send('emails.verify-email', ['data' => $data], function ($message) use ($data) {
            $message->to($data['email'])->subject($data['title']);
        });

        $user = User::find($user['id']);
        $user->remember_token = $random;
        $user->save();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Mail send Successfully'
        // ]);
    }

    //Mail Verification
    public function mailVerification($token)
    {
        $user = User::where('remember_token', $token)->first();
        if ($user) {
            $datetime = Carbon::now()->format('Y-m-d H:i:s');
            $user = User::find($user['id']);
            $user->remember_token = '';
            $user->is_verified = 1;
            $user->email_verified_at = $datetime;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Email Verified Successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User Not Found'
            ]);
        }
    }

    //Refresh Token
    public function refreshToken()
    {
        if (auth('api')->user()) {
            return $this->respondWithToken(auth('api')->refresh());
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User is not Authenticated.'
            ]);
        }
    }
}
