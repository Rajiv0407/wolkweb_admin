<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\User;
use DB;
use Hash ;
use Session ;

class customerController extends Controller
{
    
    public function index(Request $request){

    	$data['title']=siteTitle();

    	echo view('admin/customerManagement/index',$data);

    }

    public function customerData(Request $request){

    	$data['title']=siteTitle();

    	echo view('admin/customerManagement/index',$data);

    }

    public function detail(Request $request){

    	$data['title']=siteTitle();
        $userId = isset($request->userId)?$request->userId:'' ;

        $userInfo = user::find($userId) ;
        $data['userInfo']=$userInfo ;
        
    	echo view('admin/customerManagement/customerDetail',$data);

    }

    public function customerlist(Request $request){
    	$data['title']=siteTitle();

      $imgPath = config('constants.user_image');

    	$usrQry = "select id,name,case when image is null then '' else concat('".$imgPath."',image) end as image,case when username is null then '' else concat('@',username) end as username,case when registration_from=1 then 'Android' when registration_from=2 then 'IOS' else 'Admin' end as registration_from,email, phoneNumber,case when (select sum(followers_count) as totalFollowers from social_info where status=1 and user_id=users.id) is null then 0 else (select sum(followers_count) as totalFollowers from social_info where status=1 and user_id=users.id) end as followers,rank_,Date_Format(created_at,'%Y-%m-%d') as created_at,case when (select v_title from pe_countries where i_id=users.countryId and i_status=1) is null then '' else (select v_title from pe_countries where i_id=users.countryId and i_status=1) end as countryId,status from users where isTrash=0 and user_type!=1" ; 

     
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
            return $this->successResponse([],'changed status successfully'); 
         
    	}
    	 catch(\Exception $e)
        {
          return $this->errorResponse('error occurred'); 
         
        }

    }

    public function delete_customer(Request $request){

          $id=isset($request->id)?$request->id:'' ;
        try{
               user::where('id',$id)->update(array('isTrash'=>1));
                
              return $this->successResponse([],'This user has deactivated successfully'); 
        }
         catch(\Exception $e){
             return $this->errorResponse('error occurred'); 
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
