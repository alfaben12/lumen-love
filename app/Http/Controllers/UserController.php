<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $userid
     * @return \Illuminate\Http\Response
     */
    public function showOne(){
        $userid = Auth::user()->id;
        
        try {
            $data = UserModel::where('id', $userid)->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json('Cannot find Account', 404);
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'full_name' => 'required',
            'phone' => 'required',
            'sex' => 'required'
        ]);

        $userid = Auth::user()->id;

        try {
            $data = UserModel::findOrFail($userid);
            $data->username = $request->input('username');
            $data->password = app('hash')->make($request->input('password'));
            $data->email = $request->input('email');
            $data->full_name = $request->input('full_name');
            $data->phone = $request->input('phone');
            $data->sex = $request->input('sex');

            $data->save();
        
            return response()->json('Data is updated', 200);
        } catch (\Throwable $th) {
            return response()->json('Failed update', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $userid
     * @return \Illuminate\Http\Response
     */
    public function destroy(){
        $userid = Auth::user()->id;

        try {
            $data = UserModel::find($userid);
            $data->delete();
            return response()->json('Data is deleted', 200);
        } catch (\Throwable $th) {
            return response()->json('Failed delete', 404);
        }
    }
}