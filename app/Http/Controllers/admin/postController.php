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

class postController extends Controller
{


    public function postList(Request $request){

        $data['title']=siteTitle();

        echo view('admin/postManagement/index',$data);

    }    

    public function post_datatable(Request $request){

        $data['title']=siteTitle();
        $usrImg = config('constants.user_image'); 
        $carQry="select p.id,u.name,case when u.image is null then '' else concat('".$usrImg."',u.image) end as image,u.username,p.message,
        (select count(*) from post_likes where post_id=p.id and isLike=1 and status=1) as total_like,(select count(*) from post_comments where postId=p.id and status=1) as total_comment,
        (select count(*) from post_share where post_id=p.id and status=1) as total_share,case when p.status=1 then 'Active' else 'Inactive' end as status_,p.createdOn,p.status   from posts as p 
        inner join users as u on u.id=p.userId" ;  
    
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

    public function postStatus(Request $request)
    {

        $id=$request->id ;

        $qry="update posts set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }
}

?>