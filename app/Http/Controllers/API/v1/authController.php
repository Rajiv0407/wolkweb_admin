<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\User;
use Hash;
use DB ;
use Image ;
use File ;
use App\model\countries ;
use App\model\cities ;
use App\model\states ;

class AuthController extends Controller
{

    public function testData(){
        echo "Hello LesGo" ;

    }

    public function register(Request $request)
    {         
      

        try
        {
            $rules=[
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required',
            'isAgreeTC' => 'required',
            'mobile_Code' =>  'required',
            'mobile_Number' => 'numeric|required|unique:users'
           ] ;

            $validatedData = Validator::make($request->all(),$rules);
       
        if($validatedData->fails()){       
            return $this->errorResponse($validatedData->errors()->first(), 401);
          }
           
                
             $validatedData_ = $request->validate($rules);
            $validatedData_['password'] = bcrypt($request->password);
            $user = User::create($validatedData_);
            $userId =$user->id ;
            $token = $user->createToken('authToken')->accessToken;
            $data['token'] = $token  ;
            $message = "Successfull signup" ;

         $uuid=getUserConversationId($userId,0);
        
            return $this->successResponse($data,$message,200);   

        }
        catch(\Exception $e)
        {
           return $this->errorResponse('This user is already exist.'.$e, 422);
        }

    }

    public function login(Request $request)
    {
       
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'isTrash'=>0

        ];


       if (auth()->attempt($credentials)) {
   
        $token = auth()->user()->createToken('authToken')->accessToken;
        $data['token'] = $token  ;         
        $message = "Successfull login" ;
        return $this->successResponse($data,$message,200);

        } else {
            return $this->errorResponse('Invalid User Credentials', 401);
        }

    }

    public function forgotPassword(Request $request)
    {       
            $token = Str::random(10);
            $user = DB::table('users')->where('email', $request->email)->first();

            if (count(array($user)) < 1) {

                return $this->errorResponse('User does not exist', 401);              
            }

            $otp = "12345" ; //str_random(60) ;
            /* user update password */
            $password ="12345" ;
          $user = User::where('email', $request->email)->first();
        if(!$user){
             return $this->errorResponse('Email not found', 401);
        }

        $user->password = \Hash::make($password);
        $user->update();


            /* end update password */
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $otp,
                'created_at' => Carbon::now()
            ]); 

            $this->sendPwdEmail($request->email,$password,3);
           // $tokenData = DB::table('password_resets')->where('email', $request->email)->first();

            // Send OTP to user          
            //$data['otp'] = $otp ;
            $message='Your password has been sent to email' ;
            return $this->successResponse([],$message,200);

    }

    public function sendOtp(Request $request){

        $request->validate(['email' => 'required|email']);

    }

    public function verifyOTP(Request $request){

         $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
        'otp' => 'required'
        ]);

        if($validator->fails()){       
          return $this->errorResponse($validator->errors()->first(), 401);
        }else{
         $checkOTP = DB::table('password_resets')->where(array('token'=>$request->otp,'email'=>$request->email))->first();
         if(empty($checkOTP)){
           return $this->errorResponse('Invalid OTP', 401);
         }else{
            return $this->successResponse([],'OTP matched successfully.',200);

         }

        }

    }    

    public function resetPassword(Request $request){

        $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
        'password' => 'required', 
        'confirm_password' => 'required|same:password',
        'otp' => 'required' 
       ]);

    //check if payload is valid before moving on
    if($validator->fails()){       
        return $this->errorResponse($validator->errors()->first(), 401);
    }else{

         $password = $request->password;
         $tokenData = DB::table('password_resets')->where(array('token'=>$request->otp,'email'=>$request->email))->first();

         if(empty($tokenData)){
           return $this->errorResponse('Invalid OTP', 401);
         }

        $user = User::where('email', $tokenData->email)->first();
        if(!$user){
             return $this->errorResponse('Email not found', 401);
        }

        $user->password = \Hash::make($password);
        $user->update();

        return $this->successResponse([],'Password change successfully',200);
    
    }

   
// Validate the token
    

    }

    public function changePassword(Request $request)
    {

       $validator = Validator::make($request->all(),[
         'oldPassword' => 'required', 
         'password' => 'required', 
         'confirm_password' => 'required|same:password'
        ]);

        $authData=authguard();

        if(empty($authData)){
            $message="UnAuthorised";
            return $this->errorResponse($message, 422);
        }

        $userId=$authData->id; 
        $userInfo = User::findOrFail($userId);

      if($validator->fails()){
           return $this->errorResponse($validator->errors()->first(), 422);
        }else{ 
        
        if(Hash::check($request->oldPassword, $userInfo->password)) { 
            $userInfo->fill([
                    'password' => Hash::make($request->password)
                    ])->save();
            return $this->successResponse([],'Password Changed',200);
        } else {
           
            return $this->errorResponse('Password does not match', 422);
        }

      }
      

    }



    public function editProfile(Request $request){
        
        $authData=authguard();
            
       $rules=[
            'name' => 'required',
            'country' =>  'required',
            'state' => 'required',
            'city'=>'required',
            'zipcode'=>'required',
            'house_number'=>'required',
            'landMark'=>'required',
           ] ;

         // 'email' => 'required',
         //    'mobile_code' => 'required',
         //    'mobile_number' => 'required',

        

        if(empty($authData)){

            $message="UnAuthorised";
            return $this->errorResponse($message, 422);

        }

        $userId=$authData->id; 
        $validatedData = Validator::make($request->all(),$rules);
       
        if($validatedData->fails()){       
            return $this->errorResponse($validatedData->errors()->first(), 401);
          }
           
           try{

            //  'mobile_Code' => $request->mobile_code ,
            // 'mobile_Number' => $request->mobile_number ,         
 
           $updateData=[
           'name' => $request->name ,            
            'Country' =>  $request->country ,
            'State' => $request->state ,
            'City'=>$request->city ,
            'Zipcode'=>$request->zipcode ,
            'House_Number'=>$request->house_number ,
            'LandMark'=>$request->landMark ,
           ] ;

           $user=DB::table('users')
            ->where('id', $userId)
            ->update($updateData);

              return $this->successResponse([],'update data successfully',200);

        }
        catch(\Exception $e)
          {
             return $this->errorResponse('This user is already exist.', 422);
          }
   
    }

    public function updateProfileImage(Request $request){
   
          $rules=[
            'profile_image' => 'required'            
           ] ;

        $authData=authguard();

        if(empty($authData)){

            $message="UnAuthorised";
            return $this->errorResponse($message, 422);

        }

        $userId=$authData->id; 
        // $validatedData = Validator::make($request->all(),$rules);
       
        // if($validatedData->fails()){       
        //     return $this->errorResponse($validatedData->errors()->first(), 401);
        //   }

       try{

      if($request->hasFile('profile_image')) {
        
       $userData=User::find($userId) ;
       $imgPath='app/public/profileImage/' ;
       
       $prevImage=storage_path($imgPath.$userData->Profile_Image) ;
       $prevAppImage=storage_path($imgPath.'thumb/'.$userData->App_Image) ;
       $unlinkFiles = array($prevImage, $prevAppImage);


        //get filename with extension
        $filenamewithextension = $request->file('profile_image')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('profile_image')->getClientOriginalExtension();
  
        $filename=str_replace(' ', '_', $filename);
        $filenametostore = $filename.'_'.time().'.'.$extension;       
        $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
       
        //Upload File
        $request->file('profile_image')->storeAs('public/profileImage', $filenametostore);
        $request->file('profile_image')->storeAs('public/profileImage/thumb', $smallthumbnail);
       
         
        //create small thumbnail
        $smallthumbnailpath = public_path('storage/profileImage/thumb/'.$smallthumbnail);
        $this->createThumbnail($smallthumbnailpath, 100, 100);
           
           $updateData = [
            "Profile_Image"=>$filenametostore ,
            "App_Image"=>$smallthumbnail
          ] ;
          
         $updateRec=DB::table('users')->where('id',$userId)->update($updateData);

          if(!empty($unlinkFiles)){
            do_upload_unlink($unlinkFiles);
          }
             
         
       

        return $this->successResponse([],'updated successfully',200);

        }else{
            return $this->errorResponse('Invalid request.', 422);
        }

      }catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.', 422);
        }


           
    }

 public function createThumbnail($path, $width, $height)
    {
        
      $img = Image::make($path)->resize($width, $height)->save($path);
    }

    public function details()
    {  

     $token=Auth::guard('api')->user();     
        return response()->json(['user' => $token], 200);
    }

    public function userInfo(){
        $usrData=authguard();
        $userId=$usrData->id ;

      if(empty($usrData)){
         return $this->errorResponse('invalid request.', 422);
      }

      try{

         $file_path = url('/').'/public/storage/profileImage/';
         $qry="select id,name,email,mobile_code,mobile_number,House_Number, LandMark, Zipcode, case when Country is null then 0 else Country end as country,case when State is null then 0 else State end as state,case when City is null then 0 else city end as city,case when Profile_Image is null then '' else concat('".$file_path."',Profile_Image) end as profileImg,case when App_Image is null then '' else concat('".$file_path."','thumb/',App_Image) end as appImg from users where id=".$userId ;

         $userData = DB::select($qry);
         $usrD=isset($userData[0])?$userData[0]:[] ;
         /* vehicle info */
        $listCarQry=DB::select("select id as vehicleId,concat(manufacturer,' ',model) as carName from vehicle where status=1 and UserId=".$userId) ;
        $bookingCar = DB::select("select id as vehicleId,concat(manufacturer,' ',model) as carName from vehicle where status=1 and find_in_set(id, (select group_concat(distinct vehicleId) as vehcileId from booking where userId=".$userId." and paymentStatus='CAPTURED'))") ;
            
            $usrD->listCar = $listCarQry ;
            $usrD->rentCar = $bookingCar ;

         /*end  vehicle info*/
         $country=countries::all(['id','title'])->toArray();
         $countryId=isset($usrD->country)?$usrD->country:0 ;
         if($countryId > 0) {
                $countryN=countries::find($countryId);
                $usrD->country_title=$countryN->title ;
                
         }else{
          $usrD->country_title='' ;
         }
         
        $stateId=isset($usrD->state)?$usrD->state:0 ;
        if($stateId > 0){
                $stateN=states::find($stateId);
                $usrD->state_title=$stateN->title ;
        }else{
                $usrD->state_title='' ;
        }

        $cityId=isset($usrD->city)?$usrD->city:0 ;
        if($cityId > 0){
                $cityN=cities::find($cityId);
                $usrD->city_title=$cityN->title ;
        }else{
                $usrD->city_title='' ;
        }

         // $state=states::all(['id','countryId','title'])->toArray();
         // $city=cities::all(['id','stateId','title'])->toArray();
         
         $usrD->country_list = $country ;
        //  $usrD->state_list = $state ;
        // $usrD->city_list = $city ;
        
         return $this->successResponse($usrD,'User Data',200);

         }
         catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.', 422);
        }

    }

     public function sendPwdEmail($email,$otp,$type=0){

        if($type==1){
            $subject='Account Registration' ;
        }else if($type==2){
            $subject='Account Login' ;
        }else {
            $subject='Forgot Password' ;
        }
       $data=array(
        'email' => $email,
        'subject' => $subject,
        'message' => $otp
       );
        
        $data=sendPasswordToEmail($data);
    }

    public function state_list(Request $request){
        $countryId=$request->countryId ;
         $rules=[
            'countryId' => 'required'            
           ] ;

        $authData=authguard();

        if(empty($authData)){

            $message="UnAuthorised";
            return $this->errorResponse($message, 422);

        }

         $validatedData = Validator::make($request->all(),$rules);
       
        if($validatedData->fails()){       
            return $this->errorResponse($validatedData->errors()->first(), 401);
          }

          try{

        $sates=states::where('countryId', '=',$countryId)->select('id','title','countryId')->get() ;
            // $state=states::all(['id','countryId','title'])->toArray();
         return $this->successResponse($sates,'State Listing',200);

         }
         catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.', 422);
        }        

    }


    public function city_list(Request $request){
        

         $rules=[
            'countryId' => 'required',
            'stateId'=>  'required'            
           ] ;

        $authData=authguard();

        if(empty($authData)){

            $message="UnAuthorised";
            return $this->errorResponse($message, 422);

        }

         $validatedData = Validator::make($request->all(),$rules);
       
        if($validatedData->fails()){       
            return $this->errorResponse($validatedData->errors()->first(), 401);
          }

          try{

            $countryId=$request->countryId ;
            $stateId=$request->stateId ;
                        
        $city=cities::where('countryId', '=',$countryId)->where('stateId', '=',$stateId)->select('id','title','countryId','stateId')->get() ;
            // $state=states::all(['id','countryId','title'])->toArray();
         return $this->successResponse($city,'City Listing',200);

         }
         catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.', 422);
        }        

    }

    public function getUserId(Request $request){

        $authData=authguard();

        if(empty($authData)){

            $message="UnAuthorised";
            return $this->errorResponse($message, 422);

        }
        
        return $this->successResponse($authData,'City Listing',200);        
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

         return $this->successResponse($response,'Privacy Policy',200);     
        //    termCondition


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

         return $this->successResponse($response,'Term & Condition',200);           
    }

    public function help_(Request $request){
        
          $qry="select Content_title,Description from cms where Content_type='help'";
        $qryExe=DB::select($qry);

        $title=isset($qryExe[0]->Content_title)?$qryExe[0]->Content_title:'' ;
        $privacyPolicy=isset($qryExe[0]->Description)?$qryExe[0]->Description:'' ;
         $pp=strip_tags($privacyPolicy) ;
        $pp_=str_replace("&nbsp;", "",  $pp);      
        $response=array(
            "content_title"=>$title ,
            "description"=>$pp_ 
        );

         return $this->successResponse($response,'Term & Condition',200);
    }

    public function social_login(Request $request){

    $name=$request->input('name');    
    $email=$request->input('email');
    $socialId=$request->input('socialId');
    $type=$request->input('type');
    $mobile_number=$request->input('mobile_number');
        //type 2 >> facebook 3>> google 4 >> apple
    if($type==2){

        $query="select id as id  from users where email='".$email."' || social_id='".$socialId."'";
       $queryExe = DB::select($query);

       if(isset($queryExe[0]->id) && count($queryExe)>0){
         $userId = $queryExe[0]->id;

          User::where('id', $userId)->update(["name"=>$name,"email"=>$email ,"mobile_Number"=>$mobile_number]);

          $user=User::where('id',$userId)->first();

        $token = $user->createToken('authToken')->accessToken;
        $data['token'] = $token  ;
        $message = "Facebook login successfull" ;

            return $this->successResponse($data,$message,200);   

       }else{

        $password=mt_rand(100000,999999);

        $insertarrayData=array('name'=>$name,'email'=>$email,'password'=>bcrypt($password),'registration_type'=>2,'social_id'=>$socialId,'mobile_Number'=>$mobile_number);
     
        $user = User::create($insertarrayData); 
            $lastInsertId=$user->id;

        $token = $user->createToken('authToken')->accessToken;
        $data['token'] = $token  ;
        $message = "Facebook login successfull" ;

            return $this->successResponse($data,$message,200);   

       }


    }
    else if($type==3){


        $query="select id as id  from users where email='".$email."' || social_id='".$socialId."'";
       $queryExe = DB::select($query);

       if(isset($queryExe[0]->id) && count($queryExe)>0){
         $userId = $queryExe[0]->id;

          User::where('id', $userId)->update(["name"=>$name,"email"=>$email ,"mobile_Number"=>$mobile_number]);

          $user=User::where('id',$userId)->first();

        $token = $user->createToken('authToken')->accessToken;
        $data['token'] = $token  ;
        $message = "Google Login successfull" ;

            return $this->successResponse($data,$message,200);   

       }else{

        $password=mt_rand(100000,999999);

        $insertarrayData=array('name'=>$name,'email'=>$email,'password'=>bcrypt($password),'reg_type'=>3,'social_id'=>$socialId,'mobile_Number'=>$mobile_number);
     
        $user = User::create($insertarrayData); 
            $lastInsertId=$user->id;

        $token = $user->createToken('authToken')->accessToken;
        $data['token'] = $token  ;
        $message = "Google Login successfull" ;

        return $this->successResponse($data,$message,200);   

       }


    

    }

    else if($type==4){

        $query="select id as id  from users where email='".$email."' || social_id='".$socialId."'";
       $queryExe = DB::select($query);

       if(isset($queryExe[0]->id) && count($queryExe)>0){
         $userId = $queryExe[0]->id;

          User::where('id', $userId)->update(["name"=>$name,"email"=>$email ,"mobile_Number"=>$mobile_number]);

          $user=User::where('id',$userId)->first();

        $token = $user->createToken('authToken')->accessToken;
        $data['token'] = $token  ;
        $message = "Apple Login successfull" ;

            return $this->successResponse($data,$message,200);   

       }else{

        $password=mt_rand(100000,999999);

        $insertarrayData=array('name'=>$name,'email'=>$email,'password'=>bcrypt($password),'reg_type'=>4,'social_id'=>$socialId,'mobile_Number'=>$mobile_number);
     
        $user = User::create($insertarrayData); 
            $lastInsertId=$user->id;

        $token = $user->createToken('authToken')->accessToken;
        $data['token'] = $token  ;
        $message = "Apple Login successfull" ;

        return $this->successResponse($data,$message,200);   

       }


    }

    }
}
