<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $input = $request->identity;
        $check_user = strpos($input, '@');
        $status = 'error';
        $message = '';
        $data = null;
        $code = 401;

        $validator = Validator::make($request->all(), [
            'identity' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
        } else {
            if ($check_user) {
                // use email
                $user = User::where('email', $input)->first();

                if ($user) {
                    if (Hash::check($request->password, $user->password)) {
                        $user->generateToken();
                        $status = 'success';
                        $message = 'Login success';
                        $data = $user->toArray();
                        $code = 200;
                    } else {
                        $message = 'Login gagal, password salah';
                    }
                } else {
                    $message = 'Login gagal, email salah';
                }
            } else {
                // use username
                $user = User::where('username', $input)->first();
                
                if ($user) {
                    if (Hash::check($request->password, $user->password)) {
                        $user->generateToken();
                        $status = 'success';
                        $message = 'Login success';
                        $data = $user->toArray();
                        $code = 200;
                    } else {
                        $message = 'Login gagal, password salah';
                    }
                } else {
                    $message = 'Login gagal, username salah';
                }
            }
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function register(Request $request)
    {
        $status = 'error';
        $message = '';
        $data = null;
        $code = 401;

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
        } else {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $user->assignRole('operator');

            if ($user) {
                $user->generateToken();
                $status = 'success';
                $message = 'Register user successed';
                $data = $user->toArray();
                $code = 200;
            } else {
                $message = 'Register gagal';
            }

            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
            ], $code);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->removeToken();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout success',
            'data' => null
        ], 200);
    }
}
