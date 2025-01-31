<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Authentication extends Controller
{
    //Register user
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:business',
            'password' => 'required|min:6'
        ]);

        if ($validate->fails()) {
            return $this->sendErrorResponse(422, 'Validation failed.', $validate->errors()->first());
        }
        try {
            $avatarUrl = 'https://api.dicebear.com/9.x/' . urlencode($request->name) . '/svg';
            $user = Business::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'avatar' => $avatarUrl
            ]);

            $userDetails['user'] = $user;
            return $this->sendSuccessResponse(201, 'Account Created Successfully', $userDetails);
        } catch (\Throwable $e) {
            return $this->sendErrorResponse(500, 'Server Error. Please try again later', $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->sendErrorResponse(422, 'Validation failed.', $validate->errors()->first());
        }

        try {

            $user = Business::where('email', $request->email)->first();
            $hashed_password = Hash::check($request->password, $user->password);
            if (!$user || !$hashed_password) {
                return $this->sendErrorResponse(401, 'Incorrect Email or Password.');
            }

            $userDetails['user'] = $user;
            $userDetails['token'] = $user->createToken('authToken')->plainTextToken;

            return $this->sendSuccessResponse(201, 'Logged in Successfully', $userDetails);
        } catch (\Throwable $e) {

            return $this->sendErrorResponse(500, 'Server Error. Please try again later', $e->getMessage());
        }
    }
}
