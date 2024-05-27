<?php

namespace App\Http\Controllers\API\V1\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\SetProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function setProfile(SetProfileRequest $request){
        try{
            DB::beginTransaction();
            $user = $request->attributes->get('user');
           
            
            $userDetails = User::where('id', $user->id)->first();
            
           
            if(isset($request->first_name)){
                $userDetails->first_name = $request->first_name;
            }
            if(isset($request->last_name)){
                $userDetails->last_name = $request->last_name;
            }
            if($request->hasFile('user_image')){
                $uploadCropFile = $request->file('user_image');
              
                $cropFileName = $user->id . '.' . $uploadCropFile->getClientOriginalExtension();
                $cropFilePath = "public/{$user->id}/UserProfile/{$cropFileName}";
                Storage::put($cropFilePath, file_get_contents($uploadCropFile));
                $userDetails->user_image = $cropFilePath;
            }
            $userDetails->save();
            DB::commit();
            return response()->json(['type' =>'success','status'=>true,'code'=>200,'message'=>'Profile updated', 'data' => $userDetails]);
        }catch(\Exception $e){
            DB::rollBack();
            Log::info('profile Error : ' . $e->getMessage() . " " . $e->getLine());


            return response()->json(['type' => 'error','status'=>false,'code'=>200, 'message' => 'Error while processing']);
        }

    }
}
