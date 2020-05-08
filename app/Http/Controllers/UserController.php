<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class UserController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllUsers(){
        try {
            $data = UserModel::get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json('Data not found', 404);
        }
        return response()->json($data);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOneUser($id){
        try {
            $data = UserModel::where('id',$id)->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json('Data not found', 404);
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'full_name' => 'required',
            'phone' => 'required',
            'sex' => 'required'
        ]);

        try {
            $data = new UserModel();
            $data->username = $request->input('username');
            $data->password = $request->input('password');
            $data->email = $request->input('email');
            $data->full_name = $request->input('full_name');
            $data->phone = $request->input('phone');
            $data->sex = $request->input('sex');
            $data->save();
            return response()->json('Data is created', 201);
        } catch (\Throwable $th) {
            return response()->json('Failed create', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email',
            'full_name' => 'required',
            'phone' => 'required',
            'sex' => 'required'
        ]);

        try {
            $data = UserModel::findOrFail($id);
            $data->username = $request->input('username');
            $data->password = $request->input('password');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try {
            $data = UserModel::find($id);
            $data->delete();
            return response()->json('Data is deleted', 200);
        } catch (\Throwable $th) {
            return response()->json('Failed delete', 404);
        }
    }
}