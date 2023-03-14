<?php
//
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use DB ; 
use App\models\countries ;
use Image ;
use Illuminate\Support\Facades\Validator;

class masterController extends Controller
{



public function createThumbnail($path, $width, $height)
    {
        
      $img = Image::make($path)->resize($width, $height)->save($path);
    }
    
    public function countryList(Request $request){

        $data['title']=siteTitle();

        echo view('admin/master/country/index',$data);

    }    

    public function country_datatable(Request $request){

        $data['title']=siteTitle();
        
        $carQry="select i_id as id,v_title as title,api_code,case when i_status=1 then 'Active' else 'Inactive' end as status_,i_status as status from pe_countries" ;   
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

     public function saveCountry(Request $request){
           
            $cTitle = isset($request->sTitle)?$request->sTitle:'' ;
            $cCode = isset($request->apiCode)?$request->apiCode:'' ;

        try{

        $insertData = array(
             "v_title"=>$request->sTitle,
             "api_code"=>$cCode,
             "i_status"=>1
        );

        $check= countries::where('v_title', '=', $cTitle)->get()->toArray() ;

       
        if(empty($check)){
            countries::insert($insertData) ;
            echo successResponse([],'Feature save successfully.'); 
        }else{
          echo errorResponse([],'Already exist this country.');        
        }
     
        
            

      }catch(\Exception $e)
        {
             echo errorResponse('Error occurred.');     
          
        }
        
       
    }

     public function deleteCountry(Request $request){

        $deleteId=isset($request->id)?$request->id:'' ;
        try{
                countries::where('i_id', $deleteId)->delete();

              echo successResponse([],'successfully deleted'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

    }

     public function editCountry(Request $request){

          $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
           $countryInfo = countries::where('i_id',$updatedId)->first() ;
           
           $data['countryInfo'] = $countryInfo ;
           $data['updatedId']=$updatedId ;

          echo view('admin/master/country/editCountry',$data);
    }


     public function updateCountry(Request $request){
      
          $updateId = isset($request->updatedId)?$request->updatedId:'' ;
          $editCTitle = isset($request->editSTitle)?$request->editSTitle:'' ;
          $editCode = isset($request->edit_apiCode)?$request->edit_apiCode:'' ;
          $updateData = array(
                "v_title"=>$editCTitle,
                "api_code"=>$editCode
            ) ;

        try{
              countries::where('i_id',$updateId)->update($updateData) ;
              echo successResponse([],'successfully updated country '); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }         
    }
    
     public function countryStatus(Request $request)
    {

        $id=$request->id ;

        $qry="update pe_countries set i_status=(case when i_status=1 then 0 else 1 end) where i_id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

    
    

    public function privacyPolicy(){

        $qry="select Content_title,Description from cms where Content_type='privacyPolicy'";
        $qryExe=DB::select($qry);

        $title=isset($qryExe[0]->Content_title)?$qryExe[0]->Content_title:'' ;
        $privacyPolicy=isset($qryExe[0]->Description)?$qryExe[0]->Description:'' ;
        $pp=strip_tags($privacyPolicy) ;
        $pp_=str_replace("&nbsp;", "",  $pp);        
        $response=array(
            "content_title"=>$title ,
            "description"=>$pp_
        );

       //  return $this->successResponse($response,'Privacy Policy',200);     
        //    termCondition
         $data['privacyPolicy'] = $pp_ ;
        $data['title'] = $title ;
        echo view('site/cms/privacyPolicy',$data); 

    }


    public function termCondition(){
        
         $qry="select Content_title,Description from cms where Content_type='termCondition'";
        $qryExe=DB::select($qry);

        $title=isset($qryExe[0]->Content_title)?$qryExe[0]->Content_title:'' ;
        $privacyPolicy=isset($qryExe[0]->Description)?$qryExe[0]->Description:'' ;
         $pp=strip_tags($privacyPolicy) ;
        $pp_=str_replace("&nbsp;", "",  $pp);      
        $response=array(
            "content_title"=>$title ,
            "description"=>$pp_ 
        );

        // return $this->successResponse($response,'Term & Condition',200);
        $data['termCondition'] = $pp_ ;
        $data['title'] = $title ;
        echo view('site/cms/termCondition',$data);           
    }
    
    public function notificationFor_datatable(){

        $data['title']=siteTitle();
        $carQry="select id,title,case when status=1 then 'Active' else 'Inactive' end as status_,status from notification_type" ;
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

    public function rankType_datatable(){
        $data['title']=siteTitle();
    
        $rankImgPath=config('constants.star_image');
        $carQry="select id,rank_title as title,range_from,range_to,case when (star_img='' || star_img is null) then '' else concat('".$rankImgPath."',star_img) end as star_img,case when status=1 then 'Active' else 'Inactive' end as status_,
        status from rank_types" ;    
       
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

    public function interestList(){
       $data['title']=siteTitle();

        echo view('admin/master/interest/index',$data);
    }


     public function interest_datatable(Request $request){

        $data['title']=siteTitle();
        
        $carQry="select id,title,case when status=1 then 'Active' else 'Inactive' end as status_,status as status from user_interests" ;   
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

    public function interestStatus(Request $request)
    {

        $id=$request->id ;

        $qry="update user_interests set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

      public function deleteInterest(Request $request){

        $deleteId=isset($request->id)?$request->id:'' ;
        try{
                DB::table('user_interests')->where('id', $deleteId)->delete();

              echo successResponse([],'successfully deleted'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

    }

      public function editInterest(Request $request){

          $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
           $countryInfo = DB::table('user_interests')->where('id',$updatedId)->first() ;
           
           $data['interestInfo'] = $countryInfo ;
           $data['updatedId']=$updatedId ;

          echo view('admin/master/interest/editNFor',$data);
    }


     public function updateInterest(Request $request){
      
          $updateId = isset($request->updatedId)?$request->updatedId:'' ;
          $editCTitle = isset($request->editSTitle)?$request->editSTitle:'' ;
         
          $updateData = array(
                "title"=>$editCTitle                
            ) ;

        try{
              DB::table('user_interests')->where('id',$updateId)->update($updateData) ;
              echo successResponse([],'successfully updated interest '); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }         
    }

     public function saveInterest(Request $request){
           
            $cTitle = isset($request->sTitle)?$request->sTitle:'' ;
            

        try{

        $insertData = array(
             "title"=>$request->sTitle,            
             "status"=>1
        );

        $check= DB::table('user_interests')->where('title', '=', $cTitle)->get()->toArray() ;

       
        if(empty($check)){
            DB::table('user_interests')->insert($insertData) ;
            echo successResponse([],'Feature save successfully.'); 
        }else{
          echo errorResponse([],'Already exist this country.');        
        }
     
        
            

      }catch(\Exception $e)
        {
             echo errorResponse('Error occurred.');     
          
        }
        
       
    }

    public function sponserList(){
       $data['title']=siteTitle();

        echo view('admin/master/sponser/index',$data);
    }


     public function sponser_datatable(Request $request){

        $data['title']=siteTitle();
        $img=config('constants.sponser_image');
        $carQry="select id,name,email,case when image is null then '' else concat('".$img."',image) end as image,description,case when status=1 then 'Active' else 'Inactive' end as status_,status as status from sponser" ;  
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

    public function sponserStatus(Request $request)
    {

        $id=$request->id ;

        $qry="update sponser set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

    public function save_sponser(Request $request){
        $data['title']=siteTitle();
        $name=isset($request->sTitle)?$request->sTitle:'' ;
        $email = isset($request->email)?$request->email:'' ;
        $description = isset($request->description)?$request->description:'' ;
        $filenametostore='';
        try{
            
            if($request->hasFile('sImage')) {
        
       
                $imgPath='app/public/sponser_img/' ;
                
              
                 $filenamewithextension = $request->file('sImage')->getClientOriginalName();
           
                 //get filename without extension
                 $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
           
                 //get file extension
                 $extension = $request->file('sImage')->getClientOriginalExtension();
           
                 $filename=str_replace(' ', '_', $filename);
                 $filenametostore = $filename.'_'.time().'.'.$extension;       
                 $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
                
                 //Upload File
                 $request->file('sImage')->storeAs('public/sponser_img', $filenametostore);
                // $request->file('sImage')->storeAs('public/star_type_img/thumb', $smallthumbnail);
                
                  
                 //create small thumbnail
                // $smallthumbnailpath = public_path('storage/star_type_img/thumb/'.$smallthumbnail);
                // $this->createThumbnail($smallthumbnailpath, 100, 100);                 
                   
          
                }

                $insertData=array(
                    'name'=>$name ,
                    'email'=>$email,
                    'description'=>$description,  
                    'image'=>$filenametostore,
                    'status'=>1
                );
                			
            DB::table('sponser')->insert($insertData);
           echo successResponse([],'saved successfully'); 

        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
    }

    public function sponserDelete(Request $request){

        $deleteId=isset($request->id)?$request->id:'' ;
        try{
                DB::table('sponser')->where('id', $deleteId)->delete();

              echo successResponse([],'successfully deleted'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

    }

    public function editSponser(Request $request){

        $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
         $countryInfo = DB::table('sponser')->where('id',$updatedId)->first() ;
         
         $data['sponserInfo'] = $countryInfo ;
         $data['updatedId']=$updatedId ;

        echo view('admin/master/sponser/editNFor',$data);
  }

  public function updateSponser(Request $request){
        $data['title']=siteTitle();
        $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
        $name=isset($request->editSTitle)?$request->editSTitle:'' ;
        $email = isset($request->editEmail)?$request->editEmail:'' ;
        $description = isset($request->editDescription)?$request->editDescription:'' ;
        $filenametostore='';

        $updateData=array(
            'name'=>$name ,
            'email'=>$email,
            'description'=>$description           
        );
    
        try{
            
            if($request->hasFile('editSImage')) {
        
       
                $imgPath='app/public/sponser_img/' ;
                
              
                 $filenamewithextension = $request->file('editSImage')->getClientOriginalName();
           
                 //get filename without extension
                 $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
           
                 //get file extension
                 $extension = $request->file('editSImage')->getClientOriginalExtension();
           
                 $filename=str_replace(' ', '_', $filename);
                 $filenametostore = $filename.'_'.time().'.'.$extension;       
                 $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
                
                 //Upload File
                 $request->file('editSImage')->storeAs('public/sponser_img', $filenametostore);
                // $request->file('sImage')->storeAs('public/star_type_img/thumb', $smallthumbnail);
                
                  
                 //create small thumbnail
                // $smallthumbnailpath = public_path('storage/star_type_img/thumb/'.$smallthumbnail);
                // $this->createThumbnail($smallthumbnailpath, 100, 100);                 
                $checkPV = DB::table('sponser')->select(DB::raw('case when image is null then "" else image end as image'))->where('id',$updatedId)->first();
                if(isset($checkPV->image) && $checkPV->image!=''){
                    $unlinkPath = storage_path($imgPath.$checkPV->image) ;
                    do_upload_unlink(array($unlinkPath));
                }

                $updateData['image']=$filenametostore;
                }

               
                			
            DB::table('sponser')->where('id',$updatedId)->update($updateData);
           echo successResponse([],'Updated successfully'); 

        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
  }
}
