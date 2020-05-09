<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function signin(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only(['email', 'password']);

        try {
            $data = UserModel::where([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ])->first();

            if (!$token = Auth::attempt($credentials)) {
                return response()->json('Incorrect username and/or password.', 401);
            }
            
            return response()->json([
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
                'message' => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json('Incorrect username and/or password.', 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'full_name' => 'required',
            'phone' => 'required',
            'sex' => 'required'
        ]);

        $data = UserModel::where('username', $request->input('username'))->orWhere('email', $request->input('email'))->first();

        if (!$data) {
            try {
                $data = new UserModel();
                $data->username = $request->input('username');
                $data->password = app('hash')->make($request->input('password'));
                $data->email = $request->input('email');
                $data->full_name = $request->input('full_name');
                $data->phone = $request->input('phone');
                $data->sex = $request->input('sex');
                $data->save();
                return response()->json('Successfully created account', 201);
            } catch (\Throwable $th) {
                return response()->json('Opps sorry failed create account, try again later!', 404);
            }
        }else{
            return response()->json('Username and/or email already taken', 200);
        }
    }
}