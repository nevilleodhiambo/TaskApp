<?php

namespace App\Http\Controllers;

use App\Events\NewUserCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    private $secretKey = "VNjdfXp6WfaswTNPWk60woGI2NCwm1LU1718435148";

    public function register(Request $request)
    {
        $field = $request->all();

        $errors = Validator::make($field, [
            'email' => 'required |email|unique:users,email',
            'password' => 'required|min:6|max:8',

        ]);
        
        if ($errors->fails()) {
            return response($errors->errors()->all(), 422);
        }

        $user = User::create([
            'email' => $field['email'],
            'password' => $field['password'],
            'isValidEmail' => User::IS_INVALID_EMAIL,
            'remember_token' => $this->generateRandomCode()
        ]);

        NewUserCreated::dispatch($user);
        
        return response(['user' => $user, 'message' => 'user Created Successfull'], 200);
    }
    public function verify($token)
    {
         User::where('remember_token', $token)
            ->update(['isValidEmail' => User::IS_VALID_EMAIL]);

        return redirect('/login');
    }
    public function generateRandomCode()
    {
        $code = Str::random(10).time();
        return $code;
    }
    public function login(Request $request)
    {
        $field = $request->all();

        $errors = Validator::make($field, [
            'email' => 'required|email',
            'password' => 'required',

        ]);
       
        if ($errors->fails()) {
            return response($errors->errors()->all(), 422);
        }

        $user = User::where('email', $field['email'])->first();

        if (!is_null($user)) {
            if (intval($user->isValidEmail) !== User::IS_VALID_EMAIL) {
                NewUserCreated::dispatch($user);
                return response(['message' => 'We send you an email verification !']);
            }
        Log::info('success2');

            if (!$user || !Hash::check($field['password'], $user->password)) {
                return response(['message' => 'Invalid Credentials', 'isLoggedIn' => true], 422);
            }

            $token = $user->createToken($this->secretKey)->plainTextToken;
            return response([
                'user' => $user,
                'message' => 'logged In',
                'token' => $token,
                'isLoggedIn' => true
            ], 200);
        }
        NewUserCreated::dispatch($user);
        return response(['user' => $user, 'message' => 'user Created Successfull'], 200);
    }
}
