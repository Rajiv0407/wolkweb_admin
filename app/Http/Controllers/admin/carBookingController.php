<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\User ;
use DB;
use Hash ;

class carBookingController extends Controller
{
    public function index(Request $request){

    	$data['title']='LesGo';

    	echo view('admin/carBooking/index',$data);

    }

    public function detail(Request $request){

    	$data['title']='LesGo';

    	echo view('admin/carBooking/carBookingDetail',$data);

    }

     public function carBooking_datatable(Request $request){
     
      $carBooking = "select id,id as id0,user_name,user_email,case when (select mobile_Number from users where id=userId) is null then '' else (select mobile_Number from users where id=userId) end  as mobile_Number,case when (select manufacturer from vehicle where id=vehicleId) is null then '' else (select manufacturer from vehicle where id=vehicleId) end as carName ,pickupTo,returnTo, Date_format(bookingDate,'%d %M %Y & %h : %i %p') as bookingDate, Date_format(returnDate,'%d %M %Y & %h : %i %p') as returnDate,concat(amount,'AED') as amount, case when paymentType=1 then 'Credit Card' when paymentType=3 then 'Net Banking' when paymentType=2 then 'Debit Card' when paymentType=4 then 'Cash' else '' end as paymentType,case when paymentStatus='CAPTURED' then 'Success' else 'Failed' end as paymentStatus,vehicleId,paymentType as ptype,Date_format(bookingDate,'%Y-%m-%d') as bookingDate_,Date_format(returnDate,'%Y-%m-%d') as returnDate_ from booking  " ; 

        $carBookingData = DB::select($carBooking); 
        $tableData = Datatables::of($carBookingData)->make(true);  
        return $tableData; 

     }

    


}
