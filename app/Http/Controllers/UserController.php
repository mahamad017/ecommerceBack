<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
    public function createUser(Request $request){
            $request->validate([
                'email' => 'required|string|email|max:255|unique:'.User::class,
                'password' => ['required', 'confirmed'],
            ]);
        return DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);


             // Attempt to login the user after creation
            return response()->json(['success'=>true,'data'=>$user]);

        });
    }
        public function destroy($id)
    {
        try {
            $user = User::find($id);
            if(!$user){
                response()->json(['error' => 'the user not found'], 400);
            }
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete user'], 500);
        }
    }
    }


