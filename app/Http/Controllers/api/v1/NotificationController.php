<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Hash;
use DB ;
use Image ;
use File ;
use Mail ;

class NotificationController extends Controller
{
     public function save_token(Request $request){
        
        $rules=[   
            'deviceToken' => 'required',
            'deviceType' => 'required'               
           ] ;
           			
            $validatedData = Validator::make($request->all(),$rules);
           
        if($validatedData->fails()){       
            return $this->errorResponse($validatedData->errors()->first(), 401);
          }

          $userId = authguard()->id ;
          $deviceToken=$request->deviceToken ;
          $deviceType=$request->deviceType ;
          			
          $insertData=array(
            "userId"=>$userId ,
            "deviceToken"=>$deviceToken ,
            "deviceType"=>$deviceType 
          );
          DB::table('device_token')->insert($insertData);
          return $this->successResponse([],'Successfully Saved',200);    
    }


}