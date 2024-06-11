<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $field = $request->all();

        $errors = Validator::make($field, [
            'email' => 'required |email',
            'password' => 'required|min:6|max:8',

        ]);
        // if($errors->fails()){
        //     return response()->json(['error'=>$errors->messages()], 422);
        // }
        if($errors->fails()){
            return response($errors->errors()->all(), 422);
        }
        User::create([
            'email' => $field['email'],
            'password' => $field['password'],
            'isValidEmail' => User::IS_VALID_EMAIL,
            'remeber_token' => $this->generateRandomCode()
        ]);
        return response(['message', 'user Created Successfull']);
    }
    public function generateRandomCode(){
        $code = Str::random(10 . time());
        return $code;
    }
}
