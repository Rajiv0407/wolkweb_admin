<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Hash;
use Session ;
use DB ;
use Auth ;
use Cookie;

class administratorController extends Controller
{
    public function login(Request $request){

    	$data['title']='LesGo' ;

      if($request->hasCookie('userName') != false){
        $data['userName']=Cookie::get('userName') ;
      }else{
        $data['userName']="" ;
      }

      if($request->hasCookie('userPassword') != false){
         $data['userPassword']=Cookie::get('userPassword') ;
      }else{
         $data['userPassword']="" ;
      }
  
    	return view('admin/login',$data);
    }

    public function do_login(Request $request){
    //    $password = '12345' ;
    // echo    Hash::make($password) ;
    // exit ;
        $credentials = [
            'email' => $request->txtUserName,
            'password' => $request->txtPassword,
            'user_type' => 1,
            'isTrash' => 0
        ];

       if (auth()->attempt($credentials)) {
       	$userData = auth()->user() ;
       	$userId = $userData->id ;
       	$userType = $userData->user_type ;
        $rememberMe = $request->rememberMe ;
      
         $session_data = array('userId' => $userId,
                                'userType' => $userType,
                                'userName' =>$userData->name,
                                'userEmail' =>$userData->email,
                                'userPhone' =>$userData->mobile_Number                              
                                );
         Session::put('admin_session', $session_data); 

        if($rememberMe==1){
        Cookie::queue('userName', $request->txtUserName, 60);
        Cookie::queue('userPassword', $request->txtPassword, 60);      
        }
        
        echo 'succ';
      
   		}else{

   			echo "fail" ;
   		}

    }

    
    public function logout(Request $request){
      $data['title']='LesGo' ;
       Auth::logout();    
       Session::flush();
      return redirect('/administrator');
    }

    public function adminSignup___(Request $request){
         
         $request['name']='walkofweb' ;
         $request['email']='amit.intigate@gmail.com' ;
         $request['phoneNumber']='7289057538' ;
         $request['password']='Intigate@123' ;
         $request['password_confirmation']='Intigate@123' ;
         $request['user_type']=1 ;
         $request['countryId']=91 ;

         try
        {         
            
            $rules=[            
            'name' => 'required',
            'email' => 'email|required',
            'phoneNumber' => 'required|numeric',
            'password' => 'required|confirmed',
            'countryId' => 'required'            
           ] ;

            $validatedData = Validator::make($request->all(),$rules);
      
 
        if($validatedData->fails()){       
            return $this->errorResponse($validatedData->errors()->first(), 401);
          }

          $name=$request->name ;
          $usrName = substr($name,0,2);
                
          // new

          $country_code = DB::table('pe_countries')->select('api_code')->where('i_id', $request->countryId)->first();
          $request['country_code'] = (!empty($country_code))?$country_code->api_code:'' ;
          $request['name'] = $request->name;
          $request['rank_type'] = rand(1,5);
          $request['rank_'] = 0;
          $request['username'] ='' ; //$userName;
          $request['password']=Hash::make($request['password']);
          $request['remember_token'] = Str::random(10);
          $user = User::create($request->toArray());
          
          $token = $user->createToken('walkofweb token')->accessToken;
          $message = "Successfull signup" ;
          $insertId=$user->id;
          $encryptionKey = md5('wow_intigate_23'.$insertId);
          $userName = $this->UsernameGenerate($usrName,$insertId);   
          DB::table('users')->where('id',$insertId)->update(['encryption'=>$encryptionKey,'username'=>$userName]);
          $imagick=config('constants.imagick');
          if($imagick==1){
             $this->qrCode($insertId);
          }
         
          $data['token'] = $token  ;
          return $this->successResponse($data,$message,200);    

        }
        catch(\Exception $e)
        {
           return $this->errorResponse('This user is already exist.'.$e, 422);
        }


    }


    public function UsernameGenerate($usrName,$id){
      $number = mt_rand(10000,99999);
      $username = "WOW".strtoupper($usrName).$id ;
      if($this->UsernameExist($username)){
        return $this->UsernameGenerate($usrName);
      }
      return $username ; 
    }

    public function UsernameExist($usrName){
      return User::where(['username'=>$usrName])->exists();
    }


}
