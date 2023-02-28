<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use Image ;
use App\model\user_messages;
use Webpatser\Uuid\Uuid;
use App\model\message_conversationids ;

class messageController extends Controller
{  

	public function getConversation(Request $request){
	 
	  $rules = [
    	   'receiverId' => 'required'        
         ] ;

        $usrData=authguard();
        $userId=$usrData->id ;

      if(empty($usrData)){
         return $this->errorResponse('invalid request.', 422);
      }

      $request->request->add(['senderId' => $userId]);

		$validatedData = Validator::make($request->all(),$rules);

		if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401);
        }

     

		try{
			
			$receiverId=$request->receiverId ;
			$senderId=$userId ;

			$uuid=getUserConversationId($senderId,$receiverId);
            $data['conversationId']=isset($uuid['conversationId'])?$uuid['conversationId']:'' ;

            //insert parent message in mailbox with IsParent=0

        	return $this->successResponse($data,'user conversation',200);

        }
         catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.'.$e, 422);
        }
	}


	public function sendMessage(Request $request){
 		  

    	$rules = [
    	 'senderId' => 'required',
         'receiverId' => 'required',
         'message'=>'required',
         ] ;

        $usrData=authguard();
        $userId=$usrData->id ;

      if(empty($usrData)){
         return $this->errorResponse('invalid request.', 422);
      }


      $request->request->add(['senderId' => $userId]);
      $uuid=getUserConversationId($userId,$request->receiverId);

      $mailboxConvId = $uuid['id'] ;
       
       DB::table('message_conversationid')->where('id',$uuid['id'])->update(array("lastMessage"=>$request->message,'updatedOn'=>date("Y-m-d H:i"),'ReadByAdmin'=>0)) ;

		$validatedData = Validator::make($request->all(),$rules);

		if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401);
        }

        try{


        	$checkExistMessage = DB::table("mailbox")->select('Id')->where('MailConversationId',$mailboxConvId)->get();
          if(count($checkExistMessage) > 0){
            $IsParent=1 ;
          }else{
             $IsParent=0 ;
          }

         
          $insertData = array(
           "MailConversationId"=>$mailboxConvId ,
           "UserId"=>$userId ,
           "Subject" => 'Vehicle Enquiry'  ,
           "Body" => $request->message ,
           "SendBy"=>2 ,
           "IsParent"=>$IsParent,
           "CreateOn"=>date("Y-m-d H:i:s")            
          );

          DB::table('mailbox')->insert($insertData) ;
        	return $this->successResponse([],'send message successfully',200); 
        }
         catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.'.$e, 422);
        }


 	  }
    
    public function messageDetail(Request $request){
    

    	$rules = [
    	 'receiverId' => 'required',
    	 'senderId'  => 'required'
          ] ;
         
        $usrData=authguard();
      

      if(empty($usrData)){
         return $this->errorResponse('invalid request.', 422);
      }
    
    $userId=isset($usrData->id)?$usrData->id:0 ;
    $request->request->add(['senderId' => $userId]);
		$validatedData = Validator::make($request->all(),$rules);

		if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401);
        }



        try{

        //$uuid=getUserConversationId($userId,$request->receiverId);
          $senderId = $request->senderId ;
          $uuid=getUserConversationId($userId,$request->receiverId);

        $getConvId = isset($uuid['id'])?$uuid['id']:0 ;

        //$this->getConvId($mailboxConvId) ;
      
        

        $file_path = url('/').'/public/storage/profileImage/thumb/';
        $usrName = "select name from users where id=UserId" ;
        $usrImg = "select App_Image from users where id=UserId" ;
        $qry="select Id,UserId,case when UserId=".$userId." then '1' else '0' end as myMessage, case when (".$usrName.") is null then '' else (".$usrName.") end as senderName , case when (".$usrImg.") is null then ''  else concat('".$file_path."',(".$usrImg.")) end as senderImg , Body,date_format(CreateOn,'%h:%i %p') as messageTime,case when CURDATE()=date_format(CreateOn,'%Y-%m-%d') then 'Today' when DATE_SUB(CURDATE(), INTERVAL 1 DAY)=date_format(CreateOn,'%Y-%m-%d') then 'Yesterday' else date_format(CreateOn,'%M %d, %Y') end as groupby from mailbox where MailConversationId=".$getConvId." and AdminTrash=0";

      
        $qryData = DB::select($qry);
         $response=array();
            $finalResponse=array();
            
          if(!empty($qryData)){
           

            foreach($qryData as $key => $value){
               if(isset($response[$value->groupby])){
                   $response[$value->groupby]['msg'][]=$value ;
               }else{
                   $response[$value->groupby]['title']=$value->groupby ;
                   $response[$value->groupby]['msg'][]=$value ;
               }
            }


            foreach($response as $key => $val) {
              $finalResponse[]=array("title"=>$val['title'],"msg"=>$val['msg']);
            }

          }

          return $this->successResponse($finalResponse,'messages detail List',200); 		
        }
          catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.'.$e, 422);
        }

    }

    public function getConvId($conversationId){

      $qry = "select id from message_conversationid where conversationId='".$conversationId."' limit 1" ;
      $qryExe = DB::select($qry);
      $convId=isset($qryExe[0]->id)?$qryExe[0]->id:0;
      return $convId ;
    }

     public function messageList(Request $request){
     	
      $rules = [
    	  'senderId'  => 'required'
          ] ;

        $usrData=authguard();
        $userId=$usrData->id ;

	      if(empty($usrData)){
	         return $this->errorResponse('invalid request.', 422);
	      }

        $request->request->add(['senderId' => $userId]);

		$validatedData = Validator::make($request->all(),$rules);

		if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401);
        }

        try{

    //profileImg name lastmessage time
        $file_path = url('/').'/public/storage/profileImage/thumb/';
       
        $rName="select name from users where id=(case when msgc.receiverId=".$userId." then msgc.senderId else msgc.receiverId end) " ;
        $rImg="select App_Image from users where id=(case when msgc.receiverId=".$userId." then msgc.senderId else msgc.receiverId end) " ;
       
       	$qry="select case when msgc.receiverId=".$userId." then msgc.senderId else msgc.receiverId end as receiverId ,case when (".$rName.") is null then '' else (".$rName.") end as reveiverName,case when (".$rImg.") is null then '' else concat('".$file_path."',(".$rImg.")) end as profileImg, msgc.conversationId , msgc.lastMessage,case when msgc.updatedOn='1972-01-02 00:00:00' then '' else date_format(msgc.updatedOn,'%W, %d %M %Y, %h:%i %p') end as updatedOn from message_conversationid as msgc where senderId=".$userId." or  receiverId=".$userId ;
       
       	 $qryExe = DB::select($qry)	  ;
      	  return $this->successResponse($qryExe,'messages List',200); 
        
        }
         catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.'.$e, 422);
        }

     }


}
