<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\cms;
use DB;

class cmsController extends Controller
{

     public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }
    public function termCondition(Request $request){

    	$data['title']=siteTitle();
       
        $qry="select description from cms where slug='term_condition' and status=1" ;
        $tData = DB::select($qry) ;
        $description = isset($tData[0]->description)?$tData[0]->description:'' ;
        $data['description']=$description ;

    	echo view('admin/cms/termCondition',$data);

    }

    public function privacyPolicy(Request $request){

    	$data['title']=siteTitle();
        $qry="select description from cms where slug='privacy_policy' and status=1" ;
        $tData = DB::select($qry) ;
        $description = isset($tData[0]->description)?$tData[0]->description:'' ;
        $data['description']=$description ;
    	echo view('admin/cms/privacyPolicy',$data);

    }

    public function helpSupport(Request $request){

    	$data['title']='LesGo';
        $data['title']='LesGo';
        $qry="select Description from cms where Content_type='help' and status=1" ;
        $tData = DB::select($qry) ;
        $description = isset($tData[0]->Description)?$tData[0]->Description:'' ;
        $data['description']=$description ;
    	echo view('admin/cms/helpSupport',$data);

    }

    public function saveTermCondition(Request $request){
        
        $termCondition = $request->termCondition ;
        $insertData=array(
            "description"=> $termCondition
        );

        try{             
            cms::where('slug','term_condition')->update($insertData);
            echo successResponse([],'save term condition successfully'); 
        } catch(\Exception $e) {
            echo errorResponse('error occurred'.$e); 
        }
               
    }

    public function savePrivacyPolicy(Request $request){
        
        $privacyPolicy = $request->privacyPolicy ;
        $insertData=array(
            "Description"=> $privacyPolicy
        );

        try{             
            cms::where('slug','privacy_policy')->update($insertData);
            echo successResponse([],'save privacy policy successfully'); 
        } catch(\Exception $e) {
            echo errorResponse('error occurred'.$e); 
        }
               
    }

    public function saveHelp(Request $request){
        
        $helpSupport = $request->helpSupport ;
        $insertData=array(
            "Description"=> $helpSupport
        );

        try{             
            cms::where('Content_type','help')->update($insertData);
            echo successResponse([],'save privacy policy successfully'); 
        } catch(\Exception $e) {
            echo errorResponse('error occurred'.$e); 
        }
               
    }

}
