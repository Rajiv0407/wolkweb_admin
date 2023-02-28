<?php
//
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use DB ; 
use App\model\fuel_types ;
use App\model\body_types ;
use App\model\transmission_types ;
use App\model\vehicle_features ;
use App\model\countries ;
use App\model\cities ;
use App\model\states ;
use Image ;
use Illuminate\Support\Facades\Validator;

class masterController extends Controller
{
    public function fuleType(Request $request){

    	$data['title']='LesGo';

    	echo view('admin/master/fuleType/index',$data);


    }

    public function bodyType(Request $request){

    	$data['title']='LesGo';

    	echo view('admin/master/body_type/index',$data);

    }

    public function transmissionType(Request $request){

    	$data['title']='LesGo';

    	echo view('admin/master/transmission_type/index',$data);

    }

//     

     public function fuel_datatable(Request $request){

        $data['title']='LesGo';
        
        $file_path = url('/').'/public/storage/fuelTypesIcon/';
        $carQry="select id,title,case when icon is null then '' else concat('".$file_path."','/',icon) end as icon, case when status=1 then 'Active' else 'Inactive' end as status_,status from fuel_type" ;
          
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

    public function saveFuleType(Request $request){

          $rules = [
        "fuelType"=>'required',
        "icon_fuelType" => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:width=54,height=54'
       ] ;

      

      $validatedData = Validator::make($request->all(),$rules);

    if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 200);
      }



   /******************************************************************/
        $fuelType = isset($request->fuelType)?$request->fuelType:'' ;

        $insertData = array(
            "title"=> $fuelType
        ) ;

       
        try{

            if($request->hasFile('icon_fuelType')) {
        
        //get filename with extension
        $filenamewithextension = $request->file('icon_fuelType')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('icon_fuelType')->getClientOriginalExtension();
  
       
        $filenametostore = $filename.'_'.time().'.'.$extension;       
       

        //Upload File
         $request->file('icon_fuelType')->storeAs('public/fuelTypesIcon', $filenametostore);
      
       /*thumbnail*/
        // $smallthumbnail = $filename.'_75_75_'.time().'.'.$extension;
        // $request->file('icon_fuelType')->storeAs('public/fuelTypesIcon', $smallthumbnail);
        // $smallthumbnailpath = public_path('storage/fuelTypesIcon/'.$smallthumbnail);
        // $this->createThumbnail($smallthumbnailpath, 75, 75);


           $insertData['icon'] = $filenametostore ;

            
        }

                fuel_types::insert($insertData) ;
              echo successResponse([],'save fuel type successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }
     }

public function createThumbnail($path, $width, $height)
    {
        
      $img = Image::make($path)->resize($width, $height)->save($path);
    }

    public function editFuelType(Request $request){

          $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
           $fuelInfo = fuel_types::find($updatedId) ;
           $data['fuelType'] = $fuelInfo ;

          echo view('admin/master/fuleType/editFuel',$data);

    }

    public function updateFuelType(Request $request){

        $updateId = isset($request->updatedId)?$request->updatedId:'' ;
        $editFuelType = isset($request->editFuelType)?$request->editFuelType:'' ;

        $updateData = array(
            "title"=>$editFuelType
        ) ;

        try{

            if($request->hasFile('edit_icon_fuelType')) {
        
                  $rules = [
               "edit_icon_fuelType" => 'image|mimes:jpeg,png,jpg,gif,svg|dimensions:width=54,height=54'
              ] ;

      

      $validatedData = Validator::make($request->all(),$rules);

    if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 200);
      }


      /*********************************************/
        //get filename with extension
        $filenamewithextension = $request->file('edit_icon_fuelType')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('edit_icon_fuelType')->getClientOriginalExtension();
  
       
        $filenametostore = $filename.'_'.time().'.'.$extension;       
        //do_upload_unlink
        //Upload File
        $request->file('edit_icon_fuelType')->storeAs('public/fuelTypesIcon', $filenametostore);
        //  $smallthumbnail = $filename.'_75_75_'.time().'.'.$extension;
        // $request->file('edit_icon_fuelType')->storeAs('public/fuelTypesIcon', $smallthumbnail);
        // $smallthumbnailpath = public_path('storage/fuelTypesIcon/'.$smallthumbnail);
        // $this->createThumbnail($smallthumbnailpath, 75, 75);

        $updateData['icon'] = $filenametostore ;

        /* Unlink fuel icon */
          $unlinkFiles=array()  ;
          $vehicleData=fuel_types::find($updateId) ;
          $previousImg = isset($vehicleData->icon)?$vehicleData->icon:'' ;
          
          if($previousImg!=''){
            $imgPath='app/public/fuelTypesIcon/'  ;       
            $prevAppImage_=storage_path($imgPath.$previousImg) ;
            $unlinkFiles = array($prevAppImage_);   
          }
         

         if(!empty($unlinkFiles)){
            do_upload_unlink($unlinkFiles);
          }

          /* Unlink fuel icon */
        }
                fuel_types::where('id',$updateId)->update($updateData) ;
              echo successResponse([],'update fuel type successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }
   
    }

    public function deleteRecord(Request $request){

        $fuelId=isset($request->id)?$request->id:'' ;
        try{
                /* Unlink fuel icon */
          $unlinkFiles=array()  ;
          $vehicleData=fuel_types::find($fuelId) ;
          $previousImg = isset($vehicleData->icon)?$vehicleData->icon:'' ;
          
          if($previousImg!=''){
            $imgPath='app/public/fuelTypesIcon/'  ;       
            $prevAppImage_=storage_path($imgPath.$previousImg) ;
            $unlinkFiles = array($prevAppImage_);   
          }
         

         if(!empty($unlinkFiles)){
            do_upload_unlink($unlinkFiles);
          }

                fuel_types::where('id', $fuelId)->firstorfail()->delete();
              echo successResponse([],'delete fuel type successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

    }

     public function fuelStatus(Request $request)
    {

        $id=$request->id ;

        $qry="update fuel_type set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }


    public function bType_datatable(Request $request){

        $data['title']='LesGo';
        $file_path = url('/').'/public/storage/bodyTypesIcon/';
      
         $carQry="select id,title,case when icon is null then '' else concat('".$file_path."','/',icon) end as icon, case when status=1 then 'Active' else 'Inactive' end as status_,status from body_type" ;   

     
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

    public function saveBodyType(Request $request){

         $rules = [
        "bodyType"=>'required',
        "bt_icon" => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:width=54,height=54'
       ] ;

      

      $validatedData = Validator::make($request->all(),$rules);

    if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 200);
      }
 /*******************************************************************/
        $bodyType = isset($request->bodyType)?$request->bodyType:'' ;

        $insertData = array(
            "title"=> $bodyType
        ) ;

       
        try{

          if($request->hasFile('bt_icon')) {
        
        //get filename with extension
        $filenamewithextension = $request->file('bt_icon')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('bt_icon')->getClientOriginalExtension();
  
       
        $filenametostore = $filename.'_'.time().'.'.$extension;       
        
        //Upload File
       $request->file('bt_icon')->storeAs('public/bodyTypesIcon', $filenametostore);
    /*thumbnail*/
        //  $smallthumbnail = $filename.'_75_75_'.time().'.'.$extension;
        // $request->file('bt_icon')->storeAs('public/bodyTypesIcon', $smallthumbnail);
        // $smallthumbnailpath = public_path('storage/bodyTypesIcon/'.$smallthumbnail);
        // $this->createThumbnail($smallthumbnailpath, 75, 75);


           $insertData['icon'] = $filenametostore ;

            
        }
                body_types::insert($insertData) ;
              echo successResponse([],'save fuel type successfully'); 

        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

    }

    public function editBodyType(Request $request){

          $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
           $fuelInfo = body_types::find($updatedId) ;
           $data['bodyType'] = $fuelInfo ;

          echo view('admin/master/body_type/editBodyType',$data);

    }

    public function updateBodyType(Request $request){
          
          $updateId = isset($request->updatedId)?$request->updatedId:'' ;
          $editFuelType = isset($request->editFuelType)?$request->editFuelType:'' ;
  

            $updateData = array(
                "title"=>$editFuelType
            ) ;

        try{   
            if($request->hasFile('edit_bt_icon')) {
        
                 $rules = [
       
        "edit_bt_icon" => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:width=54,height=54'
       ] ;

      

      $validatedData = Validator::make($request->all(),$rules);

    if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 200);
      }



            /******************************************/



        //get filename with extension
        $filenamewithextension = $request->file('edit_bt_icon')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('edit_bt_icon')->getClientOriginalExtension();
  
       
        $filenametostore = $filename.'_'.time().'.'.$extension;       
        $request->file('edit_bt_icon')->storeAs('public/bodyTypesIcon', $filenametostore);
          /* thumbnail*/
            /*thumbnail*/
        //  $smallthumbnail = $filename.'_75_75_'.time().'.'.$extension;
        // $request->file('edit_bt_icon')->storeAs('public/bodyTypesIcon', $smallthumbnail);
        // $smallthumbnailpath = public_path('storage/bodyTypesIcon/'.$smallthumbnail);
        // $this->createThumbnail($smallthumbnailpath, 75, 75);


           $updateData['icon'] = $filenametostore ;
        }

         /*unlink exist image */  
             $unlinkFiles=array()  ;
          $vehicleData=body_types::find($updateId) ;
          $previousImg = isset($vehicleData->icon)?$vehicleData->icon:'' ;
          
          if($previousImg!=''){
            $imgPath='app/public/bodyTypesIcon/'  ;       
            $prevAppImage_=storage_path($imgPath.$previousImg) ;
            $unlinkFiles = array($prevAppImage_);   
          }
         

         if(!empty($unlinkFiles)){
            do_upload_unlink($unlinkFiles);
          }

          /*end unlink image */        

               body_types::where('id',$updateId)->update($updateData) ;
              echo successResponse([],'update fuel type successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

         
    }

    public function deleteBodyType(Request $request){

        $bodyId=isset($request->id)?$request->id:'' ;
        try{
            /*unlink exist image */  
             $unlinkFiles=array()  ;
          $vehicleData=body_types::find($bodyId) ;
          $previousImg = isset($vehicleData->icon)?$vehicleData->icon:'' ;
          
          if($previousImg!=''){
            $imgPath='app/public/bodyTypesIcon/'  ;       
            $prevAppImage_=storage_path($imgPath.$previousImg) ;
            $unlinkFiles = array($prevAppImage_);   
          }
         

         if(!empty($unlinkFiles)){
            do_upload_unlink($unlinkFiles);
          }

          /*end unlink image */        
                body_types::where('id', $bodyId)->firstorfail()->delete();
              echo successResponse([],'delete body type successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }
    }

    public function bodyTypeStatus(Request $request){

        $id=$request->id ;

        $qry="update body_type set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
    }

    public function transmission_datatable(Request $request){

        $data['title']='LesGo';
        $carQry="select id,title,case when status=1 then 'Active' else 'Inactive' end as status_,status from transmission_type" ;   
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData;

    }

    public function transChangeStatus(Request $request){

            $id=$request->id ;

        $qry="update transmission_type set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
    }

    public function deleteTransType(Request $request){

         $bodyId=isset($request->id)?$request->id:'' ;
        
        try{
             transmission_types::where('id', $bodyId)->firstorfail()->delete();
              echo successResponse([],'delete body type successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }
    }

    public function saveTransmissionType(Request $request){

        $transType = isset($request->bodyType)?$request->bodyType:'' ;

        $insertData = array(
            "title"=> $transType
        ) ;

       
        try{
                transmission_types::insert($insertData) ;
              echo successResponse([],'save transmission type successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }
    }

       public function editTransmission(Request $request){

          $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
           $transInfo = transmission_types::find($updatedId) ;
           $data['trans_type'] = $transInfo ;

          echo view('admin/master/transmission_type/editTransmission',$data);

    }
    

     public function updateTransType(Request $request){
          
          $updateId = isset($request->updatedId)?$request->updatedId:'' ;
          $editTransTitle = isset($request->editTransTitle)?$request->editTransTitle:'' ;
           

            $updateData = array(
                "title"=>$editTransTitle
            ) ;


        try{
                transmission_types::where('id',$updateId)->update($updateData) ;
              echo successResponse([],'update transmission type successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

         
    }

     public function vehicleFeatures(Request $request){

        $data['title']='LesGo';

        echo view('admin/master/features/index',$data);

    }



    public function features_datatable(Request $request){

        $data['title']='LesGo';
        
        $file_path = url('/').'/public/storage/featuresIcon/';
        $carQry="select id,title,case when (icon='' || icon is null) then '' else concat('".$file_path."',icon) end as icon,case when status=1 then 'Active' else 'Inactive' end as status_,status from vehicle_feature" ;   
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }
    
     public function featureStatus(Request $request)
    {

        $id=$request->id ;

        $qry="update vehicle_feature set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }


        public function saveFeature(Request $request){
           

        $rules = [
        "fTitle"=>'required',
        "featureIcon" => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:width=54,height=54'
       ] ;

      

      $validatedData = Validator::make($request->all(),$rules);

    if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 200);
      }






          /**********************************************/
            $fTitle = isset($request->fTitle)?$request->fTitle:'' ;

        $insertData = array(
            "title"=> $fTitle
        ) ;

       
        try{

        $insertData = array(
             "title"=>$request->fTitle
        );
  
  
      if($request->hasFile('featureIcon')) {
        
        //get filename with extension
        $filenamewithextension = $request->file('featureIcon')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('featureIcon')->getClientOriginalExtension();
  
       
        $filenametostore = $filename.'_'.time().'.'.$extension;       
        
        //Upload File
        $request->file('featureIcon')->storeAs('public/featuresIcon', $filenametostore);
    
           $insertData['icon'] = $filenametostore ;

            
        }
  
          //DB::table('vehicle_feature')->insert($insertData);
         vehicle_features::insert($insertData) ;
        
            echo successResponse([],'Feature save successfully.'); 

      }catch(\Exception $e)
        {
             echo errorResponse('Error occurred.');     
          
        }
        
       
    }


        public function deleteFeature(Request $request){

        $featureId=isset($request->id)?$request->id:'' ;
        try{

             /*unlink exist image */  
             $unlinkFiles=array()  ;
          $vehicleData=vehicle_features::find($featureId) ;
          $previousImg = isset($vehicleData->icon)?$vehicleData->icon:'' ;
          
          if($previousImg!=''){
            $imgPath='app/public/featuresIcon/'  ;       
            $prevAppImage_=storage_path($imgPath.$previousImg) ;
            $unlinkFiles = array($prevAppImage_);   
          }
         

         if(!empty($unlinkFiles)){
            do_upload_unlink($unlinkFiles);
          }

          /*end unlink image */        


                vehicle_features::where('id', $featureId)->firstorfail()->delete();
              echo successResponse([],'Successfully deleted feature'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

    }

    public function editFeature(Request $request){

          $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
           $fuelInfo = vehicle_features::find($updatedId) ;
           $data['featureInfo'] = $fuelInfo ;

          echo view('admin/master/features/editFeature',$data);
    }

    public function updateFeature(Request $request){
      
          $updateId = isset($request->updatedId)?$request->updatedId:'' ;
          $editFTitle = isset($request->editFTitle)?$request->editFTitle:'' ;
          $updateData = array(
                "title"=>$editFTitle
            ) ;

        try{
  
            if($request->hasFile('editIcon')) {
            
               $rules = [       
        "editIcon" => 'image|mimes:jpeg,png,jpg,gif,svg|dimensions:width=54,height=54'
       ] ;

      

      $validatedData = Validator::make($request->all(),$rules);

    if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 200);
      }


            $filenamewithextension = $request->file('editIcon')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('editIcon')->getClientOriginalExtension();
       
           $filenametostore = $filename.'_'.time().'.'.$extension;       
           $request->file('editIcon')->storeAs('public/featuresIcon', $filenametostore);
            $updateData['icon'] = $filenametostore ;

             /*unlink exist image */    
          $vehicleData=vehicle_features::find($updateId) ;
          $previousImg = isset($vehicleData->icon)?$vehicleData->icon:'' ;
          
          if($previousImg!=''){
            $imgPath='app/public/featuresIcon/'  ;       
            $prevAppImage_=storage_path($imgPath.$previousImg) ;
            $unlinkFiles = array($prevAppImage_);   
          }
         

         if(!empty($unlinkFiles)){
            do_upload_unlink($unlinkFiles);
          }

          /*end unlink image */        

            
        }
                vehicle_features::where('id',$updateId)->update($updateData) ;
              echo successResponse([],'successfully updated feature '); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

         
    }
    
    public function countryList(Request $request){

        $data['title']='LesGo';

        echo view('admin/master/country/index',$data);

    }    

    public function country_datatable(Request $request){

        $data['title']='LesGo';
        
        $carQry="select id,title,case when status=1 then 'Active' else 'Inactive' end as status_,status from country" ;   
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

     public function saveCountry(Request $request){
           
            $cTitle = isset($request->cTitle)?$request->cTitle:'' ;

        try{

        $insertData = array(
             "title"=>$request->cTitle,
             "status"=>1
        );

        $check= countries::where('title', '=', $cTitle)->get()->toArray() ;

       
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
                countries::where('id', $deleteId)->firstorfail()->delete();
              echo successResponse([],'successfully deleted'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

    }

     public function editCountry(Request $request){

          $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
           $countryInfo = countries::find($updatedId) ;
           $data['countryInfo'] = $countryInfo ;

          echo view('admin/master/country/editCountry',$data);
    }


     public function updateCountry(Request $request){
      
          $updateId = isset($request->updatedId)?$request->updatedId:'' ;
          $editCTitle = isset($request->editCTitle)?$request->editCTitle:'' ;
          $updateData = array(
                "title"=>$editCTitle
            ) ;

        try{
  
              countries::where('id',$updateId)->update($updateData) ;
              echo successResponse([],'successfully updated country '); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

         
    }
    
     public function countryStatus(Request $request)
    {

        $id=$request->id ;

        $qry="update country set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

     public function stateList(Request $request){

        $data['title']='LesGo';
        $country=countries::get();
        $data['country']=$country ;
        echo view('admin/master/state/index',$data);

    }    
    
     public function state_datatable(Request $request){

        $data['title']='LesGo';
      
        $carQry="select id,title,case when (select title from country where id=countryId) is null then '' else (select title from country where id=countryId) end as country,case when status=1 then 'Active' else 'Inactive' end as status_,status from state" ;   
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }
    
      public function saveState(Request $request){
           
            $sTitle = isset($request->sTitle)?$request->sTitle:'' ;
            $country = isset($request->sCountry)?$request->sCountry:'' ;

        try{
   
        $insertData = array(
            "countryId"=>$country  ,
             "title"=>$sTitle,
             "status"=>1
        );

        $check= states::where('title', '=', $sTitle)->get()->toArray() ;

        // print_r($insertData)   ;
        // exit ; 
        if(empty($check)){
            states::insert($insertData) ;
            echo successResponse([],'State save successfully.'); 
        }else{
          echo errorResponse([],'Already exist this state.');        
        }
     
        
            

      }catch(\Exception $e)
        {
             echo errorResponse('Error occurred.');     
          
        }
        
       
    }
    
     public function editState(Request $request){

        $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
        $stateInfo = states::find($updatedId) ;
        $data['stateInfo'] = $stateInfo ;
        $country=countries::get();
        $data['country']=$country ;
        echo view('admin/master/state/editState',$data);
    }
    
     public function updateState(Request $request){
      
          $updateId = isset($request->updatedId)?$request->updatedId:'' ;
          $editSTitle = isset($request->editSTitle)?$request->editSTitle:'' ;
          $countryId = isset($request->editSCountry)?$request->editSCountry:'' ;
          $updateData = array(
                "title"=>$editSTitle,
                'countryId'=>$countryId
            ) ;

        try{
  
            
                states::where('id',$updateId)->update($updateData) ;
              echo successResponse([],'successfully updated state '); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

         
    }

     public function deleteState(Request $request){

        $deleteId=isset($request->id)?$request->id:'' ;
        try{
                states::where('id', $deleteId)->firstorfail()->delete();
              echo successResponse([],'delete fuel type successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

    }

    public function stateStatus(Request $request){

            $id=$request->id ;

        $qry="update state set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
    }
    
     public function cityList(Request $request){

        $data['title']='LesGo';
        $stateId=isset($request->stateId)?$request->stateId:0;
        $stateInfo=states::find($stateId);
        $countryId=$stateInfo->countryId ;
        $data['stateId']=$stateId ;
        $data['countryId']=$countryId ;

        echo view('admin/master/city/index',$data);

    }  

     public function city_datatable(Request $request){

        $data['title']='LesGo';
        $stateId=$request->stateId ;
        $stateInfo=states::find($stateId);
        $countryId=$stateInfo->countryId ;

        $carQry="select id,title,case when (select title from country where id=countryId) is null then '' else (select title from country where id=countryId) end as country,case when (select title from state where id=stateId) is null then '' else (select title from state where id=stateId) end as state,case when status=1 then 'Active' else 'Inactive' end as status_,status from city where stateId=".$stateId." and countryId=".$countryId ;   
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }         

      public function saveCity(Request $request){
           
            $cTitle = isset($request->cTitle)?$request->cTitle:'' ;
            $countryId = isset($request->countryId_)?$request->countryId_:'' ;
            $stateId = isset($request->stateId_)?$request->stateId_:'' ;

        try{
   
        $insertData = array(
            "countryId"=>$countryId  ,
            "stateId"=>$stateId,
             "title"=>$cTitle,
             "status"=>1
        );

        $check= cities::where('title', '=', $cTitle)->get()->toArray() ;

        // print_r($insertData)   ;
        // exit ; 
        if(empty($check)){
            cities::insert($insertData) ;
            echo successResponse([],'City save successfully.'); 
        }else{
          echo errorResponse([],'Already exist this city.');        
        }

      }catch(\Exception $e)
        {
             echo errorResponse('Error occurred.');     
          
        }
    }

     public function cityStatus(Request $request){

            $id=$request->id ;

        $qry="update city set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
    }

         public function deleteCity(Request $request){

        $deleteId=isset($request->id)?$request->id:'' ;
        try{
                cities::where('id', $deleteId)->firstorfail()->delete();
              echo successResponse([],'deleted city successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }

    }
    
     public function editCity(Request $request){

          $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
           $cities = cities::find($updatedId) ;

           $data['cityInfo'] = $cities ;

          echo view('admin/master/city/editCity',$data);
    }    

     public function updateCity(Request $request){
      
          $updateId = isset($request->updatedId)?$request->updatedId:'' ;
          $editCTitle = isset($request->editCTitle)?$request->editCTitle:'' ;
          $countryId = isset($request->editCountryId)?$request->editCountryId:'' ;
          $stateId = isset($request->editStateId)?$request->editStateId:'' ;
          $updateData = array(
                "title"=>$editCTitle
            ) ;

        try{
                cities::where('id',$updateId)->update($updateData) ;
              echo successResponse([],'successfully updated city '); 
        }
         catch(\Exception $e){
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

        $data['title']='LesGo';
        $carQry="select id,title,case when status=1 then 'Active' else 'Inactive' end as status_,status from pe_announcement_for" ;
          

        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

}
