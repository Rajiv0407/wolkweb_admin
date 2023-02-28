<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use Image ;
use App\model\user_messages;
use App\model\createnotification_tokens;
use App\model\notifications;


class notificationController extends Controller
{
    public function notificationList(Request $request){

        $usrData=authguard();
        $userId=$usrData->id ;

      if(empty($usrData)){
         return $this->errorResponse('invalid request.', 422);
      }

    	try{

        $file_path = url('/').'/public/storage/profileImage/thumb/';
        $subQry="select App_Image from users where id=notification.SenderId and status=1";
    	$notification=notifications::select('Id','Title','Content',DB::raw('case when (select name from users where id=notification.SenderId) is null then "" else (select name from users where id=notification.SenderId) end as senderName'),DB::raw('case when ('.$subQry.') is null then "" else concat("'.$file_path.'",('.$subQry.')) end as profileImg'), DB::raw('date_format(CreateDate,"%W, %d %b %Y") as createdOn'))->where('ReceiverId',6)->get();
    		return $this->successResponse($notification,'notification list',200);
    	}  
    	catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.'.$e, 422);
        }

    }

    public function updateDeviceToken(Request $request){

	  $rules = [
    	   'deviceType' => 'required',
    	   'deviceToken' => 'required',
    	   'IsNotify' => 'required',
    	   'userId' => 'required'       
         ] ;

        $usrData=authguard();
        $userId=$usrData->id ;

      if(empty($usrData)){
         return $this->errorResponse('invalid request.', 422);
      }

    	 $request->request->add(['userId' => $userId]);

		$validatedData = Validator::make($request->all(),$rules);

		if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401);
        }

        try{

        	$validatedData_ = $request->validate($rules);
        	createnotification_tokens::create($validatedData_);
        	return $this->successResponse([],'update token successfully',200);   
        }
         catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.'.$e, 422);
        }

    }


 

}
