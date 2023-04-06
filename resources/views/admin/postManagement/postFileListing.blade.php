<form class="" id="n_serarchForm" action="javascript:void(0);" > 
                <div class="filterWrapper">
                    <div class="form filterWrapper__l">
                        <!-- <div class="form-group">
                            <label for="Manufacture">User Name</label>
                            <input type="text" class="form-control" placeholder="User Name" id="user_name_">
                        </div> -->
                        <!-- <div class="form-group">
                            <label for="Model">File(Image/Audio/Video)</label>
                            <input type="text" class="form-control" id="comment_" placeholder="Comment">
                        </div>   -->
                        <!-- <div class="form-group">
                            <label for="oName">Mobile Number</label>
                            <input type="text" class="form-control" id="cus_mobileNumber" placeholder="Mobile Number">
                        </div> -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="" id="comment_status_" class="form-control">
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </div>
                        <div class="d-flex">
                              
                            <a href="javascript:void(0);" class="search-btn" onclick="searchNType1()">
                                <i class="bi bi-search"></i><span>Search</span>
                            </a>
                             <a href="javascript:void(0);" class="search-btn clear-btn ml-5px" onclick="resetSearchForm()">
                                <i class="bi bi-eraser-fill"></i><span>Clear</span>
                            </a>
                        </div>
                         
                    </div>
                </div>
            </form>
<div class="table-area">
                                <table class="table" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>                                         
                                            <th scope="col">File(Image/Audio/Video)</th>   
                                            <th scope="col">Type</th>                                       
                                            <th scope="col">Status</th>
                                            <th scope="col">Created On</th>
                                            <th scope="col">File Type</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                      
                                    
                    
                        
                                    </tbody>
                                </table>
                              
                            </div>

<script type="text/javascript">

     $(document).ready(function($k){
        datatablePagination($k); 

 $('#dataTable').DataTable({
      processing: true,
      serverSide: true,
      pageLength: 10,
      retrieve: true,
      sDom: 'lrtip',
      lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
      sPaginationType: "bootstrap",
      "aaSorting": [[ 0, 'desc' ]],   
      columnDefs: [  
            {
                "aTargets": [0],
                "visible":false
            },
            {
                "aTargets": [5],
                "visible":false
            },{
                            "aTargets": [1],
                            "mRender" : function(data, type, full){ 
                              var response='' ;                             
                               
                            if(full['file_type']==1){
                                response='<img src="'+full['image']+'" width="60px" height="60px" />' ;
                            }else if(full['file_type']==2){
                                response='<a href="'+full['image']+'" download>Download</a>' ;
                            }else if(full['file_type']==3){
                                response='<a href="'+full['image']+'" download>Download</a>' ;
                            }
                            return response ;
                            }
                        } ,  
                
            {
                            "aTargets": [3],
                            "mRender" : function(data, type, full){ 
                              var action='' ;
                               var className='' ;

                            if(full['status']==1){
                              className='activeNFor' ;
                            }else{
                              className='inactiveNFor' ;
                            }

                            action+='<span class="'+className+'">'+full['status_']+'</span>';

                            return action ;
                            }
                        } ,  
                
                        {
                    "aTargets": [6],
                     "mRender": function(data, type, full){
                        var response ='<td><div class="align-items-center d-flex"><div class="more_n"> <i class="bi bi-three-dots-vertical" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink"><li><a class="dropdown-item" href="javascript:void(0);" onclick="ConfirmDelete('+full['id']+')">Delete</a></li>  </ul> </div>  <div> <label class="switch">' ;
                        
                                  
                        if(full['status']=='1'){
                             response +='<input type="checkbox" onclick="changeUsrStatus('+full['id']+')" checked>' ;
                            
                        }else{
                             response +='<input type="checkbox" onclick="changeUsrStatus('+full['id']+')" >' ;
                           
                        }

                        response+='<span class="slider"></span> </label> </div> </div> </td>'  ;

                        return response ;
                    }
                }
        
                ],

            ajax: {
                      url: '{!! URL::asset('post_file_datatable/'.$postId.'/'.$type) !!}',
                    },
             columns : [
   
                        { data: 'id' },                       
                        {data: 'image'},
                        {data: 'fileType'},
                        {data: 'status_'},
                        {data: 'createdOn'},
                        { data: 'status' },
                        {data:'file_type'}
          ],
          			
        });
      $k('.input-group-addon').click(function() {
        $k(this).prev('input').focus();
    });
         
         });


function viewVehicleImage(bookingId){
    
      $.ajax({
        type:"POST",
        url:baseUrl+'/carManagement/viewVehicleImage',
        data:{"bookingId":bookingId},
       
        beforeSend:function()
        {
            ajax_before();
        },
        success:function(html)
        {
            ajax_success() ;
           $('#vehicleIdModal').html(html);
        
        }
        });
}


function searchNType1(){
      
      var status=$("#comment_status_").val();
      var comment=$("#comment_").val();
      //var email=$("#cus_email").val();
      var userName=$("#user_name_").val();
      
 
   if(status){
 
        $('#dataTable').DataTable().column(5).search(status).draw();
  }
 
  //  if(mobileNumber){
 
  //       $('#dataTable').DataTable().column(6).search(mobileNumber).draw();
  // }

//    if(userName){
       
//         $('#dataTable').DataTable().column(1).search(userName).draw();
//   }

//   if(comment){
 
//         $('#dataTable').DataTable().column(2).search(cName).draw();
//   }

 
}

function resetSearchForm(){

var table = $('#dataTable').DataTable();
document.getElementById("n_serarchForm").reset();

postDetail('<?php echo $postId ; ?>');   
 //$('#dataTable').DataTable().ajax.reload();        

}

function changeUsrStatus(id){

ajaxCsrf();

$.ajax({
    type:"POST",
    url:baseUrl+'/postFileStatus',
    data:{"id":id},
    dataType:'json',
beforeSend:function()
{
    ajax_before();
},
success:function(res)
{
     ajax_success() ;
if(res.status==1){
var table = $('#dataTable').DataTable();
table.draw( false );
 statusMesage('changed status successfully','success');
}else{
 statusMesage('something went wrong','success');
}
}

});
}

function ConfirmDelete(id) {
    
    if(confirm("Are you sure ?")) {
        delete_customer(id);
    }
}

function delete_customer(id){
             ajaxCsrf();
        $.ajax({type:"POST",
        url:baseUrl+'/deletePostFile',
        data:{"id":id},
        dataType:'json',
        beforeSend:function()
        {
             ajax_before();
        },
        success:function(res)
        {

             ajax_success() ;

        if(res.status==1){
        //carManagement();
          $('#dataTable').DataTable().ajax.reload();                
          statusMesage('Deleted successfully','success');
        }else{
           statusMesage('Something went wrong','error');
        }
        }

        });

    }
</script>