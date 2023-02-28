<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\User ;
use DB;
use Hash ;
use Session ;

class customerController extends Controller
{
    
    public function index(Request $request){

    	$data['title']='LesGo';

    	echo view('admin/customerManagement/index',$data);

    }

    public function customerData(Request $request){

    	$data['title']='LesGo';

    	echo view('admin/customerManagement/index',$data);

    }

    public function detail(Request $request){

    	$data['title']='LesGo';
        $userId = isset($request->userId)?$request->userId:'' ;

        $userInfo = user::find($userId) ;
        $data['userInfo']=$userInfo ;
        
    	echo view('admin/customerManagement/customerDetail',$data);

    }

    public function customerlist(Request $request){
    	$data['title']='LesGo';

    	$usrQry = "select id,name,case when (mobile_Number='' || mobile_Number is null )  then '' else concat('+' , mobile_Code,' ',mobile_Number) end as mobile_Number ,email,House_Number,LandMark,City,Zipcode,State,Country ,case when status=1 then 'Active' else 'Inactive' end as status , status as userStatus from users where isTrash=0 and user_type=2" ; 
    	$usrData = DB::select($usrQry); 
        $tableData = Datatables::of($usrData)->make(true);  
        return $tableData; 
    	
    }

    public function changeStatus(Request $request)
    {

    	$id=$request->id ;

    	$qry="update users set status=(case when status=1 then 0 else 1 end) where id=".$id;

    	try{

           DB::select($qry);	
            echo successResponse([],'changed status successfully'); 
         
    	}
    	 catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

    public function delete_customer(Request $request){

          $id=isset($request->id)?$request->id:'' ;
        try{
               user::where('id',$id)->update(array('isTrash'=>1));
                
              echo successResponse([],'delete notification type successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }
    }

    public function changePassword(Request $request){
   
      $newPassword = isset($request->newPassword)?$request->newPassword:'' ;
      $confirmPwd = isset($request->confirmPwd)?$request->confirmPwd:'' ;
      $userId = isset($request->changeUserPwd)?$request->changeUserPwd:'' ;
      $password =  Hash::make($newPassword) ;

      $updateData = array(
        "password"=>$password
      );
       

       try{
              user::where('id',$userId)->update($updateData) ;           
              echo successResponse([],'changed password successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }
      
    }

     public function changeAdminPassword(Request $request){
   
      $newPassword = ($request->newAdminPassword)??'' ;
      $sessionData =Session::get('admin_session');
      $userId = ($sessionData['userId'])??0 ;
      $password =  Hash::make($newPassword) ;

      $updateData = array(
        "password"=>$password
      );
       

       try{
              user::where('id',$userId)->update($updateData) ;           
              echo successResponse([],'changed password successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }
      
    }
}
