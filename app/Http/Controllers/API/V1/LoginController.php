<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    function create_member(RegisterRequest $request){
        try{
            DB::beginTransaction();
            $user = new User();
            $user->username = $request->username;
            $user->name = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            DB::commit();
            return response()->json(['type'=>'success','code'=>200,'status'=>true,'message'=>"User created successfully"]);
        }catch(\Exception $e){
            DB::rollback();
            Log::info("Sign up error".$e->getMessage());
            return response()->json(['type'=>'error','status'=>false,'message'=>"Error while processing"]);
        }
    }
    public function Validate_credentials(LoginRequest $request){
        try{
            $password = $request->password;
            $username = $request->username;

            $user = User::where('username',$username)->first();
            if($user){
                if(Hash::check($password,$user->password)){
                    $data["username"] = $user->username;
                    $data["email"] = $user->email;
                    $authToken = generateAuthToken($user);
                    return response()->json(['type'=>'success','code'=>200,'status'=>true,'message'=>"User logged in successfully",'authToken'=>$authToken,'data'=>$data]);
                }else{
                    return response()->json(['type'=>'error','code'=>200,'status'=>false,'message'=>"Invalid password"]);
                }
            }else{
                return response()->json(['type'=>'error','code'=>200,'status'=>false,'message'=>"User not found"]);
            }

        }catch(\Exception $e){
            DB::rollBack();
            Log::info("Login error".$e->getMessage());
            return response()->json(['type'=>'error','code'=>200,'status'=>false,'message'=>"Error while processing"]);
        }

    }
}
