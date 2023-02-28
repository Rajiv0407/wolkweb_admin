<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
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
            'status' => 1
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

    

    // public function admin_dashboard(Request $request){

    //   $data['title']='LesGo' ;
    //   echo view('admin/admin_dashboard',$data);

    // }
 

    //  public function dashboard(Request $request){
      
    //     $data['title']='LesGo' ;
    //  return view('admin/dashboard',$data);
    // }
    
    public function logout(Request $request){
      $data['title']='LesGo' ;
       Auth::logout();    
       Session::flush();
      return redirect('/administrator');
    }

    
}
