<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Hepler\ResponseHelper;
use App\Http\Requests\LoginRequest;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone_number' => $request->phone_number
                ]

            );
            if ($user) {
                // return response()->json([
                //     'status' => true,
                //     'message' => 'User created successfully',
                //     'data' => $user
                // ]);
                return ResponseHelper::success('ok', 'User created successfully', $user, 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User not created',
                    'data' => $user
                ]);
            }
        } catch (Exception $exception) {
            \Log::error('Unable to create user: ' . $exception->getMessage());
            return ResponseHelper::error('Unable to create user', $exception->getMessage(), null, 500);
        }
        // dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function userProfile()
    {
        try{

            $user = Auth::user();
            if($user){
                return response()->json([
                    'status' => true,

                    'message' => 'User profile',
                    'user' => $user,

                ],200);
            }else{
               return response()->json([
                    'status' => false,
                    'message' => 'The provided credentials are incorrect.',
                ], 401);
            }
    } catch (Exception $exception) {
        \Log::error('Unable to login user: ' . $exception->getMessage());
        return ResponseHelper::error('Unable to login user', $exception->getMessage(), null, 500);
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function login(LoginRequest $request)
    {
        // dd("calling");
        try {
            // dd("calling");
            // if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            //     return ResponseHelper::error('Invalid credentials', 'Invalid credentials', null, 401);
            // }
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'The provided credentials are incorrect.',
                ], 401);
            }

            $token = $user->createToken('auth_token', ['*'], now()->addWeek(1))->plainTextToken;

            return response()->json([
                'status' => true,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
            // $u = Auth::user();
            // // dd($user);
            // $token = $u->createToken('Bareater Token')->plainTextToken;
            // // dd($token);
            // $userData = [
            //     'name' => $u,
            //     'token' => $token
            // ];
            // dd($userData);
            // // return ResponseHelper::success($status = null, $message = null, $data = null, $statusCode = 200);
            // return ResponseHelper::success(1, 'User logged in successfully', $userData, 200);
        } catch (Exception $exception) {
            \Log::error('Unable to login user: ' . $exception->getMessage());
            return ResponseHelper::error('Unable to login user', $exception->getMessage(), null, 500);
        }


        //    dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
