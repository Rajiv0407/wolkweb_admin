<?php

namespace App\Http\Controllers\api\tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\api_model\tenant\faq;
use  App\api_model\tenant\Cms as Cms_Model;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
class Cms extends Controller
{
    protected $Cms;
	 public function __construct()
    {
       $this->Cms=new Cms_Model();
    
    }

    public function get_faq(Request $request){
        $group_id=$request->input('group_id');
       $currentPage =$request->input('p_page'); // You can set this to any page you want to paginate to
      // Make sure that you call the static method currentPageResolver()
        // before querying users
        $validator = Validator::make($request->all(),[
            'group_id' => 'required',
            'p_page' => 'required',
            'p_count' => 'required'
         ]);
        //  $validator->errors()->first()->messages()
         if ($validator->fails()) 
         {
            return $this->errorResponse($validator->errors()->first(), 422);
                 }
    
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
    //DB::enableQueryLog();
        // group_id=$group_id
        $size = 10;
        $data = DB::select("select Question,Answer from faq where   Status=1 order by id desc");
        $collect = collect($data);
        $list = new LengthAwarePaginator(
                                 $collect->forPage($currentPage, $size),
                                 $collect->count(), 
                                 $size, 
                                 $currentPage
                               );
        //pa(DB::getQueryLog());
    if(!empty($list->items())){
        $data=array("list"=>$list->items(),'count'=>$list->total());
        return $this->successResponse(
            $data,"get faq Data",200); 
        }else{
            return $this->errorResponse(
                "No Data Found",401); 
        }
    
    }

    public function get_contact_support(Request $request){
        //$authData=authguard();
        $validator = Validator::make($request->all(),[
            'group_id' => 'required'
         ]);
        //  $validator->errors()->first()->messages()
         if ($validator->fails()) 
         {
            return $this->errorResponse($validator->errors()->first(), 422);
                 }

    $data=$this->Cms->get_contact_support($request);
    //pa($data);
    if(!empty($data)){
         $adddet=get_lat_long($data[0]->address);
       $data[0]->latitude=$adddet['latitude'];
       $data[0]->longitude=$adddet['longitude'];
        return $this->successResponse(
            $data[0],"Contact Support Data",200); 
    }else{
        return $this->errorResponse(
            "Oops ! Something Went Wrong",200); 
        }
    
    }

    public function get_help_data(Request $request){
        $validator = Validator::make($request->all(),[
            'group_id' => 'required'
         ]);
        //  $validator->errors()->first()->messages()
         if ($validator->fails()) 
         {
            return $this->errorResponse($validator->errors()->first(), 422);
                 }
        $data=$this->Cms->get_help_data($request);
    //    pa($data);
        if(!empty($data)){
            return $this->successResponse(
                $data[0],"Get Help Data",200); 
        }else{
            return $this->errorResponse(
                "No Data Found",200); 
            }
    }
    
    public function get_privacy_data(Request $request){
        $validator = Validator::make($request->all(),[
            'group_id' => 'required'
         ]);
        //  $validator->errors()->first()->messages()
         if ($validator->fails()) 
         {
            return $this->errorResponse($validator->errors()->first(), 422);
                 }
        $data=$this->Cms->get_privacy_data($request);
    //    pa($data);
        if(!empty($data)){
            return $this->successResponse(
                $data[0],"Get Privacy Data",200); 
        }else{
            return $this->errorResponse(
                "No Data Found",200); 
            }
    }
    public function get_tnc_data(Request $request){
        $validator = Validator::make($request->all(),[
            'group_id' => 'required'
         ]);
        //  $validator->errors()->first()->messages()
         if ($validator->fails()) 
         {
            return $this->errorResponse($validator->errors()->first(), 422);
                 }
        $data=$this->Cms->get_tnc_data($request);
       // pa($data);
        if(!empty($data)){
            return $this->successResponse(
                $data[0],"Get Tnc Data",200); 
        }else{
            return $this->errorResponse(
                "No Data Found",200); 
            }
    }

}
