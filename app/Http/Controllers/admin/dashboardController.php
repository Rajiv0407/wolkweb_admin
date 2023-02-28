<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB , session ;



class dashboardController extends Controller
{
    
     public function index(){

     	 $data['title']='LesGo' ;
    	return view('admin/dashboard',$data);

     }

   public function admin_dashboard(Request $request){

      $data['title']='LesGo' ;
      
      /* car listing  */

    
	 $carToday =DB::select('select count(*) as total_vehicle from vehicle as veh where date_format(created_at,"%Y-%m-%d")= CURDATE()') ;
	 $carToday_ = ($carToday[0]->total_vehicle)??0 ;

	 $carMonth = DB::select('select count(*) as total_vehicle from vehicle as veh where date_format(created_at,"%Y")= YEAR(CURDATE())') ;
     $carMonth_ = ($carMonth[0]->total_vehicle)??0 ;

     $carYear = DB::select('select count(*) as total_vehicle from vehicle as veh where date_format(created_at,"%m")= MONTH(CURDATE())') ;
     $carYear_ = ($carYear[0]->total_vehicle)??0;

    
     $data['carToday']= $carToday_ ;
     $data['carMonth']= $carMonth_ ;
     $data['carYear']= $carYear_ ; 
	/* Car booking  */

	$bookingToday = DB::select('select count(*) as total_booking , sum(amount) as amount from  booking as b where date_format(createdOn,"%Y-%m-%d")= CURDATE()') ;
	$bookingToday_ = ($bookingToday[0]->total_booking)??0; 
    $bookingTodayAmt_ = ($bookingToday[0]->amount)??0; 

	$bookingMonth = DB::select('select count(*) as total_booking,sum(amount) as amount from  booking as b where date_format(createdOn,"%m")= MONTH(CURDATE())') ;
	$bookingMonth_ = ($bookingMonth[0]->total_booking)??0;
	$bookingMonthAmt_ = ($bookingToday[0]->amount)??0;  

    $bookingYear = DB::select('select count(*) as total_booking , sum(amount) as amount from  booking as b where date_format(createdOn,"%Y")= YEAR(CURDATE())') ;
    $bookingYear_ = ($bookingYear[0]->total_booking)??0; 
    $bookingYearAmt_ = ($bookingToday[0]->amount)??0; 


    $bookingWeekly = DB::select('select count(*) as total_booking , case when sum(amount) is null then 0 else sum(amount) end as amount from  booking as b where createdOn > DATE_SUB(NOW(), INTERVAL 1 WEEK)') ;

    $bookingWeekly_ = ($bookingWeekly[0]->total_booking)??0; 
    $bookingWeeklyAmt_ = ($bookingWeekly[0]->amount)??0;  

     $data['bookingToday'] = $bookingToday_ ;
     $data['bookingMonth'] = $bookingMonth_ ;
     $data['bookingYear'] = $bookingYear_ ;

     $data['bookingTodayAmt'] = $bookingTodayAmt_ ;
     $data['bookingMonthAmt'] = $bookingMonthAmt_ ;
     $data['bookingYearAmt'] = $bookingYearAmt_ ;

     $data['bookingWeeklyAmt'] = $bookingWeeklyAmt_  ;
     $data['bookingWeekly'] = $bookingWeekly_ ;


	/* Customer registration  */

	$userToday = DB::select('select count(*) as total_users from users as veh where date_format(created_at,"%Y-%m-%d")= CURDATE()') ;
	$userToday_ = ($userToday[0]->total_users)??0 ;

    $userYear = DB::select('select count(*) as total_users from users as veh where date_format(created_at,"%Y")= YEAR(CURDATE())') ;
    $userYear_ = ($userYear[0]->total_users)??0 ;

    $userMonth  = DB::select('select count(*) as total_users from users as veh where date_format(created_at,"%m")= MONTH(CURDATE())') ;
    $userMonth_ = ($userMonth[0]->total_users)??0 ;
     
     $data['userToday'] = $userToday_ ;
     $data['userMonth'] = $userMonth_ ;
     $data['userYear'] = $userYear_ ;

      echo view('admin/admin_dashboard',$data);

    }

    public function bookingYearlyChart(){
            /* first Level */
    
    // $bookingYear = DB::select('select Year(createdOn) as yearSales, sum(amount) as amount from  booking as b group by Year(createdOn)') ;
    /* first level */
DB::select("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
    $bookingYear = DB::table('booking')
                 ->select( DB::raw('Year(createdOn) as yearSales'), DB::raw('ROUND(sum(amount),2) as amount'))
                 ->groupBy(DB::raw('Year(createdOn)'))
                 ->get();



    if(!empty($bookingYear)){
        $yearlySales = [] ;
        $drilldownData = [] ;
        foreach ($bookingYear as $key => $value) {
           $yearlySales[]=array("name"=>$value->yearSales ,"y"=>$value->amount ,"drilldown"=>(int)$value->yearSales);

          $drilldownData__ = $this->monthwiseChart($value->yearSales) ;
          if(!empty($drilldownData__)){
             foreach ($drilldownData__ as $key => $value) {
              $drilldownData[]=$value ;
             }
          }
        
        }
    }

 
    $response = array('yearly'=>$yearlySales,'drilldownData'=>$drilldownData) ;
   echo json_encode($response) ;



    
    }

    public function monthwiseChart($year){
       
         // $bookingMonth = DB::select('select Month(createdOn) as monthS,Year(createdOn) as year_ , MonthName(createdOn) as monthName_, sum(amount) as amount from booking as b where Year(b.createdOn)="'.$year.'"   group by Month(b.createdOn)') ;
      DB::select("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
         $bookingMonth = DB::table('booking')
                 ->select( DB::raw('Month(createdOn) as monthS'), DB::raw('Year(createdOn) as year_'),DB::raw('MonthName(createdOn) as monthName_'),DB::raw('Round(sum(amount),2) as amount'))
                 ->whereRaw("Year(createdOn)='".$year."'")
                 ->groupBy(DB::raw('Month(createdOn)'))
                 ->get();

      if(!empty($bookingMonth)){
        $finalArray= [] ;
        $monthlySales = [] ;
        $DayWiseSales = [] ;
        foreach ($bookingMonth as $key => $value) {

            $month=$value->monthS ;
            $monthName_ = $value->monthName_ ;
            $year_ = $value->year_ ;
            $amount = $value->amount ;
            $monthDrillName =  $monthName_.$year_ ;
                $monthlySales[]=array("name"=>$monthName_ ,"y"=>$amount ,"drilldown"=>$monthDrillName);
           $finalArray[] = $this->dayWiseSalesChart($month,$monthDrillName,$year) ;       
           
        }
        
         $finalArray[]=array("name"=>$year ,"id"=>(int)$year,"data"=>$monthlySales) ;

    }
        return $finalArray ;
    }

    public function dayWiseSalesChart($month,$monthDrillName,$year){
        $dayWiseData = [] ;
        // $bookingDaywise = DB::select('select MonthName(createdOn) as monthN,Day(createdOn) as days, DayName(createdOn) as daySales, sum(amount) as amount from booking as b where Month(createdOn)='.$month.' and Year(createdOn)='.$year.' group by Day(createdOn)') ;
DB::select("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
            $bookingDaywise = DB::table('booking')
                 ->select( DB::raw('MonthName(createdOn) as monthN'), DB::raw('Day(createdOn) as days'),DB::raw('DayName(createdOn) as daySales'),DB::raw('Round(sum(amount),2) as amount'))
                 ->whereRaw("Month(createdOn)='".$month."'")
                 ->whereRaw("Year(createdOn)='".$year."'")
                 ->groupBy(DB::raw('Month(createdOn)'))
                 ->get();



        if(!empty($bookingDaywise)){               
        
            foreach ($bookingDaywise as $key => $val) {
                $DayWiseSales[]=array($val->days,$val->amount); 
             }

             $dayWiseData=array("name"=>$val->monthN , "id"=>$monthDrillName,"data"=>$DayWiseSales) ;
        }

        return $dayWiseData ;
    }
}
