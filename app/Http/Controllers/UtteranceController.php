<?php

namespace App\Http\Controllers;

use App\Models\UtteranceModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class UtteranceController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll(){
        $userid = Auth::user()->id;
       
        try {
            $data = UtteranceModel::where('id',$id)->get();
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
    public function showOne($id){
        $userid = Auth::user()->id;
        
        try {
            $data = UtteranceModel::where('id', $id)->get();
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
            'receiver' => 'required',
            'message' => 'required',
            'public' => 'required',
            'active_at' => 'required',
            'expired_at' => 'required'
        ]);

        $userid = Auth::user()->id;

        try {
            $data = new UtteranceModel();
            $data->userid = $userid;
            $data->qrcode = $uuid = Uuid::uuid4();
            $data->receiver = $request->input('receiver');
            $data->message = $request->input('message');
            $data->public = $request->input('public');
            $data->active_at = $request->input('active_at');
            $data->expired_at = $request->input('expired_at');
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
            'receiver' => 'required',
            'message' => 'required',
            'public' => 'required',
            'active_at' => 'required',
            'expired_at' => 'required'
        ]);

        $userid = Auth::user()->id;

        try {
            $data = UtteranceModel::findOrFail($id);
            $data->userid = $userid;
            $data->qrcode = $uuid = Uuid::uuid4();
            $data->receiver = $request->input('receiver');
            $data->message = $request->input('message');
            $data->public = $request->input('public');
            $data->active_at = $request->input('active_at');
            $data->expired_at = $request->input('expired_at');
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
        $userid = Auth::user()->id;
        
        try {
            $data = UtteranceModel::find($id);
            $data->delete();
            return response()->json('Data is deleted', 200);
        } catch (\Throwable $th) {
            return response()->json('Failed delete', 404);
        }
    }
}