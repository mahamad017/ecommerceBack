<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function show(Request $request){
       try{

           $uses = User::all();
         return
         response()->json([
            'status'=>'success',
            'data'=>$uses,
            ],200);
        }catch(\Exception $e){
             return  response() -> json([
                 "status"=>"error",
                 "message"=> $e->getMessage()],$e->getCode());
        }


    }
}
