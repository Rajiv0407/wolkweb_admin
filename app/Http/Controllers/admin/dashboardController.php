<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB , session ;
use Carbon\Carbon;
use DateTime;

class dashboardController extends Controller
{
    
     public function index(){

     	 $data['title']=siteTitle() ;
         //return "Dashboard" ; exit ;
    	return view('admin/dashboard',$data);

     }

   public function admin_dashboard(Request $request){

     $data['title']=siteTitle() ;

    //   current weeks and previous week graph
    //   Top 7 Advertisers
    //   Traffic by Location
    //   Traffic by Platform         
       
     $activeUser = DB::table('users')->select(DB::raw('count(*) as totalActiveUser'))->where('isTrash',0)->where('user_type','!=',1)->first();
     $deactivateUser = DB::table('users')->select(DB::raw('count(*) as totalDeActiveUser'))->where('isTrash',1)->where('user_type','!=',1)->first();
     $newUser = DB::table('users')->select(DB::raw('count(*) as newUser'))->where('isTrash',0)->where('user_type','!=',1)->whereDate('created_at', Carbon::today())->first();
     
     $activeUser_ = isset($activeUser->totalActiveUser)?$activeUser->totalActiveUser:0 ;
     $deactiveUser_ = isset($deactivateUser->totalDeActiveUser)?$deactivateUser->totalDeActiveUser:0 ;
     $newUser_ = isset($newUser->newUser)?$newUser->newUser:0 ;
     $data['active_user']=$activeUser_ ;
     $data['deactive_user']=$deactiveUser_ ;
     $data['new_user'] = $newUser_ ;
     $data['total_app_download'] = 0  ;  

    
    //  $date = "01 April 2023";
    //  dd(date('Y-m-d', strtotime($date)));
      echo view('admin/admin_dashboard',$data);

    }

    public function trafficByPlateForm(){
        $deviceTypeQry="select case when registration_from=1 then 'Android' when registration_from=2 then 'IOS' else 'Other' end as name,
        count(*) as y from users where user_type!=1 and isTrash=0 group by registration_from" ;
        $deviceType=DB::Select($deviceTypeQry);
        $dTResponse=array() ;
   
        if(!empty($deviceType)){
           foreach($deviceType as $val){
               $dTResponse[]=array('name'=>$val->name,'y'=>$val->y);
           }
        }
   
       return json_encode($dTResponse);
   
    }
    
    public function trafficByLocation(){

       $qry="select count(*) as totalUser,pc.title from users as u inner join pe_countries as pc on pc.id=u.countryId where u.countryId is not null group by u.countryId";
       $qryExe=DB::select($qry);
       $dTResponse=array();
       if(!empty($qry)){
          
         foreach($qryExe as $val){
            $dTResponse[]=array($val->title,$val->totalUser);
         }
       }       
       return json_encode($dTResponse);
        
    }
    

    public function advertisementChart(){
        $qry="select count(*) as totalAdvertisement, adv.createdBy,u.name from advertisements as adv  
        left join users as u on u.id=adv.createdBy where adv.createdBy!=1 group by adv.createdBy order by count(*) desc limit 7";
        $qryExe=DB::select($qry);
        $dTcategory=array();
        $dTPoint=array();
        if(!empty($qryExe)){
            foreach($qryExe as $val){
                $dTcategory[] = $val->name;
                $dTPoint[]=$val->totalAdvertisement;
            }
        }
        $dTResponse=array('category'=>$dTcategory,'point'=>$dTPoint);
        return json_encode($dTResponse);
    }
    
    public function currentWeekReport(){

        $yearWiseUser=DB::select("select Year(u.created_at) as year_ from users as u where u.isTrash=0 and u.user_type!=1 group by Year(u.created_at)");

        $dTResponse=array();

        if(!empty($yearWiseUser)){
          foreach($yearWiseUser as $val){
            $userData=DB::select("select count(*) as totalUser,Month(u.created_at) as monthN,DATE_FORMAT(u.created_at,'%b') as month from users as u where u.isTrash=0 and u.user_type!=1 and Year(u.created_at)=".$val->year_." group by Month(u.created_at) order by Month(u.created_at)");
            $year=$val->year_ ;
            $monthData=array('1'=>'','2'=>'','3'=>'','4'=>'','5'=>'','6'=>'','7'=>'','8'=>'','9'=>'','10'=>'','11'=>'','12'=>'');
            if(!empty($userData)){
              foreach($userData as $val_){
                $monthData[$val_->monthN]=$val_->totalUser ;
              }
            }
            $dTResponse[]=array('name'=>$year,'data'=>array_values($monthData));
          }
        }       
       
       //$point=array(array('name'=>'2023','data'=>array(1600,18,600,500,800,966,400,622,358,781,963,500)),array('name'=>'2023','data'=>array(1600,18,0,500,800,966,400,622,358,781,963,0)));
        $point=$dTResponse ;
        $category=array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
        $dTResponse=array('category'=>$category,'point'=>$point);
        return json_encode($dTResponse);
    }

}
