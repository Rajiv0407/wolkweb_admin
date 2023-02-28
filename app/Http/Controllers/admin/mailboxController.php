<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator ;
use DB ;
use Session ;

class mailboxController extends Controller
{
    public function index(Request $request){

    	$data['title']='LesGo';

        $messageType = isset($request->messageType)?$request->messageType:0 ;    	
        // $inboxList = DB::table("mailbox")->select(DB::raw("mailbox.Id as mailId"),"MailConversationId", "UserId","Subject","Body",DB::raw("date_format(mailbox.CreateOn,'%d-%m-%y %h:%i %p') as senderDate"),"lastMessage")->join('message_conversationid', 'message_conversationid.id', '=', 'mailbox.MailConversationId')->where('IsParent',0)->where('AdminTrash',0)->get() ;

       // $inboxList=DB::table("message_conversationid")->where("ReadByAdmin","0")->where("isTrashByAdmin","0")->get(); 


        // select("select count(*) as unReadConversation from message_conversationid where ReadByAdmin=0 and isTrashByAdmin=0");
        $data['totalInboxMssg']=getUnreadMessage() ; //$inboxList->count() ;
        $trashList = DB::table("mailbox")->select(DB::raw("mailbox.Id as mailId"),"MailConversationId", "UserId","Subject","Body",DB::raw("date_format(message_conversationid.updatedOn,'%d-%m-%y %h:%i %p') as senderDate"),"lastMessage")->join('message_conversationid', 'message_conversationid.id', '=', 'mailbox.MailConversationId')->where('IsParent',0)->where('AdminTrash',1)->get() ;
        $data['totalTrashMssg']=$trashList->count() ;

        $limitR = 10 ;
        $data['limitR'] = $limitR  ;


        $inbox_list = DB::table("mailbox")->select(DB::raw("mailbox.Id as mailId"),"MailConversationId", DB::raw("message_conversationid.ReadByAdmin as readbyAdmin"), DB::raw("message_conversationid.isTrashByAdmin as isTrash"),"UserId","Subject","Body",DB::raw("date_format(message_conversationid.updatedOn,'%d-%m-%y %h:%i %p') as senderDate"),"lastMessage")->join('message_conversationid', 'message_conversationid.id', '=', 'mailbox.MailConversationId')->where('IsParent',0)->where('AdminTrash',$messageType)->paginate($limitR);
        $data['messageType']=$messageType ;
    	$data['inbox_list']=$inbox_list ;

          if ($request->ajax()) {
            return view('admin/mailbox/inbox_listing', $data);
        }
        return view('admin/mailbox/index',$data);
    	// echo view('admin/mailbox/index',$data);

    }

    public function ajax_inboxList(Request $request){
    	
    	$data['title']='LesGo';
        $limitR = 10 ;
        $data['limitR'] = $limitR  ;
        $searchData = isset($request->searchData)?$request->searchData:'' ;
        $messageType = isset($request->messageType)?$request->messageType:0 ;
 //DB::enableQueryLog();

        if($searchData==''){

            $inbox_list = DB::table("mailbox")->select(DB::raw("mailbox.Id as mailId"),"MailConversationId", DB::raw("message_conversationid.ReadByAdmin as readbyAdmin"), DB::raw("message_conversationid.isTrashByAdmin as isTrash"),"UserId","Subject","Body",DB::raw("date_format(message_conversationid.updatedOn,'%d-%m-%y %h:%i %p') as senderDate"),"lastMessage")->join('message_conversationid', 'message_conversationid.id', '=', 'mailbox.MailConversationId')      
        ->where('IsParent',0)->where('AdminTrash',$messageType)->paginate($limitR);
    
        } else {

            $inbox_list = DB::table("mailbox")->select(DB::raw("mailbox.Id as mailId"),"MailConversationId",DB::raw("message_conversationid.ReadByAdmin as readbyAdmin"), DB::raw("message_conversationid.isTrashByAdmin as isTrash"), "UserId","Subject","Body",DB::raw("date_format(message_conversationid.updatedOn,'%d-%m-%y %h:%i %p') as senderDate"),"lastMessage")->join('message_conversationid', 'message_conversationid.id', '=', 'mailbox.MailConversationId')
         ->where('IsParent',0)->where('AdminTrash',$messageType)
         ->whereRaw("(select email from users where id=UserId) like '%{$searchData}%'")
        ->orWhereRaw("(select mobile_Number from users where id=UserId) like '%{$searchData}%'")
        ->paginate($limitR);

        }

        $data['messageType']=$messageType ;
        //dd(DB::getQueryLog());
    	$data['inbox_list']=$inbox_list ;
    	echo view('admin/mailbox/inbox_listing',$data);

    }

    public function detail(Request $request){

    	$data['title']='LesGo';
   
       
       $messageType = isset($request->messageType)?$request->messageType:0 ;
       $currentPage = isset($request->currentPage)?$request->currentPage:0 ;
    	$mailConvId = isset($request->mailConvId)?$request->mailConvId:0 ;
        $userInfo = ($request->session()->has('admin_session'))?session('admin_session'):array() ;
    	
        $updateData = array(
            "ReadByAdmin"=>1
        ) ;
        
        DB::table('message_conversationid')->where('id',$mailConvId)->update($updateData);

        $login_userName=($userInfo['userName'])??'' ;
    	$login_userId=($userInfo['userId'])??'' ;
    	$login_email = ($userInfo['userEmail'])??'' ;

		$messageDetail = DB::select("select ml.Id as mailId,ml.MailConversationId, ml.UserId,ml.Subject,ml.Body,Date_format(ml.CreateOn,'%d %b %Y %h:%i %p') as senderDate, u.name,case when mobile_Number is null then '' else concat(mobile_Code,' ',mobile_Number) end as mobileNumber,u.email from mailbox as ml inner join users as u on u.id=ml.userId where ml.MailConversationId=".$mailConvId);
 
		$data['login_userName']=$login_userName ;
		$data['login_userId']=$login_userId ;
		$data['login_email']=$login_email ;

    	$data['message_detail']=$messageDetail ;
    	$data['conversationId'] = $mailConvId ;
        $data['currentPage']=$currentPage ;
        $data['messageType']= $messageType ;
    	echo view('admin/mailbox/mailDetail',$data);

    }

    public function messageReply(Request $request){

        $convId = ($request->conversationId)??0;
        $msgReply = ($request->messageReply)??0;

        $currentDateTime = date("Y-m-d h:i:s") ;
         $sessionInfo = session::get('admin_session') ;
        $loginUserName=$sessionInfo['userName'] ;
         $contactNumber = $sessionInfo['userPhone'] ;
         $emailId = $sessionInfo['userEmail'] ;
         $loginUserId = $sessionInfo['userId'] ;
        
        $insertData=array(
            "MailConversationId"=>$convId ,
            "Body"=>$msgReply ,
            "SendBy"=>1 ,
            "UserId"=>$loginUserId,
            "IsParent" => 1 ,
            "CreateOn" => $currentDateTime         
        );


        $updateData = array(
            "lastMessage" => $msgReply
        );
        
       

        try{
    
              DB::table('message_conversationid')->where("id",$convId)->update($updateData) ;

            $response = DB::table('mailbox')->insert($insertData) ; 

            $resp=array("message_time"=>date("d M Y h:i A",strtotime($currentDateTime)),'login_usrName'=>$loginUserName,'contact_number'=>$contactNumber,'emailId'=>$emailId) ;
            echo successResponse($resp ,'sucessfull submit'); 
         
        }
         catch(\Exception $e)
        {

          echo errorResponse('error occurred'.$e); 
         
        }

    }

    public function delDetailMessage(Request $request){
        
        $convId = ($request->convId)??0 ;

         DB::delete('update mailbox set AdminTrash=1 WHERE MailConversationId = ? and IsParent!=0', [$convId]);
         echo successResponse([] ,'sucessfull submit'); 
    }

    public function deleteInboxMessg(Request $request){

        $mailId = ($request->inboxMsg)??array() ;
        $messageType = ($request->messageType)??'' ;



        if(!empty($mailId)){
            if($messageType==1){

            $getConvId = "delete from message_conversationid where find_in_set(id,(select group_concat(MailConversationId) from mailbox where Id IN('".implode("','",$mailId)."')))" ;

             $qry="delete from mailbox  WHERE Id IN('".implode("','",$mailId)."')" ;  

            }else{

         $getConvId = "update message_conversationid set isTrashByAdmin=1 where find_in_set(id,(select group_concat(MailConversationId) from mailbox where Id IN('".implode("','",$mailId)."')))" ;
        
             $qry="update mailbox set AdminTrash=1 WHERE Id IN('".implode("','",$mailId)."')" ;  

            }
           
           DB::delete($getConvId);           
           DB::delete($qry);
            echo successResponse([] ,'sucessfull submit');      
        }else{
             echo errorResponse('error occurred');    
        }
    }

    public function messageInfo(){
        // $inboxList = DB::table("mailbox")->select(DB::raw("mailbox.Id as mailId"),"MailConversationId", "UserId","Subject","Body",DB::raw("date_format(mailbox.CreateOn,'%d-%m-%y %h:%i %p') as senderDate"),"lastMessage")->join('message_conversationid', 'message_conversationid.id', '=', 'mailbox.MailConversationId')->where('IsParent',0)->where('AdminTrash',0)->get() ;
        $data['totalInboxMssg']=getUnreadMessage() ; 
        //$inboxList->count() ;

         $trashList = DB::table("mailbox")->select(DB::raw("mailbox.Id as mailId"),"MailConversationId", "UserId","Subject","Body",DB::raw("date_format(mailbox.CreateOn,'%d-%m-%y %h:%i %p') as senderDate"),"lastMessage")->join('message_conversationid', 'message_conversationid.id', '=', 'mailbox.MailConversationId')->where('IsParent',0)->where('AdminTrash',1)->get() ;
        $data['totalTrashMssg']=$trashList->count() ;
       

        echo view('admin/mailbox/messageInfo',$data);

    }

    public function getUnreadCount(Request $request){
        return getUnreadMessage() ;
    }
}
