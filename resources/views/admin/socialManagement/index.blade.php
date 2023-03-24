<div class="carManagement__wrapper">
                <div class="breadcrumbWrapper d-flex align-items-center justify-content-between">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Social Management</h3>
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()" >Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Social Management</li>
                        </ol>
                    </nav>
                  <div class="rightButton">
                        <a href="javascript:void(0);" onclick="showModal('add_body456')" class="border-btn d-flax" ><i class="bi bi-plus"></i><span>Add Soical</span></a>
                    </div>
                </div>

                
                
                <form class="" id="n_serarchForm" action="javascript:void(0);" > 
                <div class="filterWrapper">
                    <div class="form filterWrapper__l">
                        <div class="form-group">
                            <label for="Model">Title</label>
                            <input type="text" class="form-control" id="title" placeholder="Title">
                        </div>  
                        <!-- <div class="form-group">
                            <label for="oName">Mobile Number</label>
                            <input type="text" class="form-control" id="cus_mobileNumber" placeholder="Mobile Number">
                        </div> -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="" id="social_status" class="form-control">
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </div>
                        <div class="d-flex">
                              
                            <a href="javascript:void(0);" class="search-btn" onclick="searchNType()">
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
                                <th scope="col">Title</th>
                                <th scope="col" width="10%">Weightage</th>
                                <th scope="col" width="10%">status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>    
                
    <div class="modal fade right_side" id="add_body456" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout add_motification_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Social</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" method="post" id="fuelTypeForm">
         
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Title</label>  
                         <input type="text" name="social_title" id="social_title"  class="form-control" placeholder="Title">
                         <span id="err_social_title" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Weightage</label>
                         <input type="text" name="weightage" id="weightage"  class="form-control" placeholder="Weightage">
                         <span id="err_weightage" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="javascript:void(0);"  onclick="submitNotifyFor()" class="search-btn">Submit</a>
                    <a href="javascript:void(0);" id="cancelBType" onclick="cancelFeature()" class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>

        
<div class="modal fade right_side" id="edit_body" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout edit_body_typ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Social</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" id="editBodyTypeMb">                
                
            </div>
        </div>
    </div>
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
                    "aTargets": [4],
                     "mRender": function(data, type, full){
                        var response ='<td><div class="align-items-center d-flex"><div class="more_n"> <i class="bi bi-three-dots-vertical" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink"><li><a class="dropdown-item" href="javascript:void(0);"  onclick="editNFor('+full["id"]+')" >Edit</a></li> <li><a class="dropdown-item" href="javascript:void(0);" onclick="ConfirmDelete('+full['id']+')">Delete</a></li>  </ul> </div>  <div> <label class="switch">' ;
                        
                                  
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
                      url: '{!! URL::asset('socialDatatable') !!}',
                    },
             columns : [
             
                        { data: 'id' },
                        { data: 'title' },
                        { data: 'weightage' },
                        { data: 'status' },
                        { data: 'status_' },
                        

          ],
         
        });

      $k('.input-group-addon').click(function() {
        $k(this).prev('input').focus();
    });
         

});

function submitNotifyFor(){
ajaxCsrf();
var social_title=$('#social_title').val();
var weightage=$('#weightage').val();
$('.err').html('');
if(social_title==''){
 $('#err_social_title').html('Please select title.');
}else if(weightage==''){
  $('#err_weightage').html('Please enter weightage.');
} else {
   var formData=new FormData($('#fuelTypeForm')[0]);
     $.ajax({
       type: "POST",
       url: baseUrl + '/SaveSocial',
       data:formData ,
       dataType:'json',
       cache:false,
       contentType:false,
       processData:false,
       beforeSend: function () {
              ajax_before();
       },
       success: function(html){
        ajax_success() ;
           if(html.status==1){
               $('#fuelTypeForm')[0].reset();  
               $('#add_body456').modal('hide'); 
               $('.modal-backdrop').remove();    
                removeModelOpen();
               $('#dataTable').DataTable().ajax.reload();
                 statusMesage('Save successfully','success');
             }else{
                 statusMesage(html.message,'error');
             }
           }
           });   

}
}

function cancelFeature(){
$('#social_title').val('');
$('#weightage').val('');
}

function changeUsrStatus(id){
    ajaxCsrf();
    $.ajax({
        type:"POST",
        url:baseUrl+'/socialStatus',
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

function resetSearchForm(){

    var table = $('#dataTable').DataTable();
    document.getElementById("n_serarchForm").reset();
  socialManagement();
     //$('#dataTable').DataTable().ajax.reload();        
  
}

function editNFor(updatedId){   

ajaxCsrf();
$('#edit_body').modal('show') ;
$.ajax({
    type: "POST",
    url: baseUrl +'/editsocial',
    data:{'updatedId':updatedId} ,           
    cache: 'FALSE',
    beforeSend: function () {
           ajax_before();
    },
    success: function(html){
     ajax_success() ;
       $('#editBodyTypeMb').html(html) ;
        }
    });   
}

function updateNFor(){
    
var edit_social_title=$('#edit_social_title').val();
var edit_social_weightage=$('#edit_social_weightage').val();
ajaxCsrf();
$('.err').html('');
if(edit_social_title==''){
 $('#err_edit_social_title').html('Please enter social title.');
}else if(edit_social_weightage==''){
  $('#err_edit_social_weightage').html('Please enter social weightage.');
}else {

$('.err').html('');
var formData=new FormData($('#editFeatureForm')[0]);

$.ajax({
    type: "POST",
    url: baseUrl +'/updatesocial',
    data:formData ,
    dataType:'json',
    cache: 'FALSE',
        contentType:false,
        processData:false,
    beforeSend: function () {
           ajax_before();
    },
    success: function(html){
     ajax_success() ;
     if(html.status==1){

         modalHide_('edit_body'); 
        // $('.modal-backdrop').hide();   
        $('#dataTable').DataTable().ajax.reload();
        statusMesage('Update successfully','success');
        // $('#edit_fuel').modal('hide');  
                   
     }else{
         statusMesage('Something went wrong','error');
     }
      
    
            }
    });      




}


}

function searchNType(){
      
      var title=$("#title").val();
      var social_status=$("#social_status").val();
        if(title){
                $('#dataTable').DataTable().column(1).search(title).draw();
        }
        if(social_status){
                $('#dataTable').DataTable().column(3).search(social_status).draw();
        }
}

  
   
function ConfirmDelete(id) {
    
    if(confirm("Are you sure ?")) {
        delete_customer(id);
    }
}

    function delete_customer(id){
             ajaxCsrf();
        $.ajax({type:"POST",
        url:baseUrl+'/socialDelete',    
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

   
 function updateChangePwd(){
    
        var newPwd = $('#newPassword').val();
        var confirmPwd = $('#confirmPassword').val();

        $('.err').html('') ;
        if(newPwd==''){
            $('#err_newPassword').html('Please enter new password') ;
        }else if(confirmPwd==''){
            $('#err_confirmPwd').html('Please enter confirm password') ;
        }else if(newPwd!=confirmPwd){
            $('#err_confirmPwd').html('both password must be matched') ;
        }else{

               var formData = $('#changePassword_').val() ;

                 ajaxCsrf();

        $.ajax({
            type:"POST",
            url:baseUrl+'/changePassword',
            data:formData,
            dataType:'json',
            beforeSend:function()
            {
                 ajax_before();
            },
            success:function(res)
            {

                 ajax_success() ;

            if(res.status==1){
            $('.modal-backdrop').hide();      
            $('#changePassword_')[0].reset();
            $('#change_pass').modal('hide');
            $('#dataTable').DataTable().ajax.reload();                
              statusMesage('password updated successfully','success');
            }else{
               statusMesage('something went wrong','error');
            }
            }

            });
    }
 }

function changePassword(userId){
    $('#changeUserPwd').val(userId);
}
 function cancelChangePwd(){

    $('#changePassword_')[0].reset();


 }
 
</script>