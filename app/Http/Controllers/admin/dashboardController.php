<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB , session ;



class dashboardController extends Controller
{
    
     public function index(){

     	 $data['title']='LesGo' ;
         //return "Dashboard" ; exit ;
    	return view('admin/dashboard',$data);

     }

   public function admin_dashboard(Request $request){

      $data['title']='LesGo' ;
      
      /* car listing  */
    

      echo view('admin/admin_dashboard',$data);

    }

    public function bookingYearlyChart(){
          

    $response = array('yearly'=>[],'drilldownData'=>[]) ;
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
