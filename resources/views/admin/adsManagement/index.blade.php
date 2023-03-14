
            <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper d-flex align-items-center justify-content-between">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Ads Management</h3>
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()" >Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ads Management</li>
                        </ol>
                    </nav>
                  <div class="rightButton">
                        <a href="javascript:void(0);" onclick="showModal('add_body456')" class="border-btn d-flax" ><i class="bi bi-plus"></i><span>Add Ads</span></a>
                    </div>
                </div>

                
                
                <form class="" id="n_serarchForm" action="javascript:void(0);" > 
                <div class="filterWrapper">
                    <div class="form filterWrapper__l">
                        <div class="form-group">
                            <label for="Manufacture">Sponser Name</label>
                            <input type="text" class="form-control" placeholder="Sponser Name" id="cust_name">
                        </div>
                        <div class="form-group">
                            <label for="Model">Ads Title</label>
                            <input type="text" class="form-control" id="username" placeholder="Ads Title">
                        </div>  
                        <!-- <div class="form-group">
                            <label for="oName">Mobile Number</label>
                            <input type="text" class="form-control" id="cus_mobileNumber" placeholder="Mobile Number">
                        </div> -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="" id="cust_status" class="form-control">
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
                                <th scope="col">Sponser Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Ads Type</th>
                                <th scope="col">Ads</th>
                                <th scope="col" >Start Date</th>
                                <th scope="col">End Date</th>
                                <!-- <th scope="col">Ads Created Date</th>                             -->
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
                <h5 class="modal-title" id="exampleModalLabel">Add Ads</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" method="post" id="fuelTypeForm">
         
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Sponser</label>
                        <select name="sponser_" id="sponser_" class="form-control" >
                            <option value="">Select</option>
                            <?php if(!empty($sponser)){ 
                                foreach($sponser as $val){ ?>
                                <option value="<?php echo $val->id ; ?>"><?php echo $val->name ; ?></option>
                            <?php } } ?>
                        </select>
                        
                         <span id="err_sponser_" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Title</label>
                         <input type="text" name="ads_title" id="ads_title"  class="form-control" placeholder="Title">
                         <span id="err_ads_title" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Ads Type</label>                         
                        <select name="ads_type" id="ads_type" class="form-control" >
                            <option value="">Select</option>
                            <option value="1">Image</option>
                            <option value="2">Video</option>
                        </select>
                         <span id="err_ads_type" class="err" style="color:red"></span>
                    </div>
                </div>
    
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Start Date</label>
                         <input type="date" name="startDate" id="startDate"  class="form-control" placeholder="Start Date">
                         <span id="err_startDate" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">End Date</label>
                         <input type="date" name="endDate" id="endDate"  class="form-control" placeholder="End Date">
                         <span id="err_endDate" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Ads</label>
                         <input type="file" name="adsFile" id="adsFile"  class="form-control" placeholder="Ads File">
                         <span id="err_adsFile" class="err" style="color:red"></span>
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

        <div class="modal fade right_side" id="change_pass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout edit_body_typ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" method="post" class="form-control" id="changePassword_"> 
                <input type="hidden" name="changeUserPwd" id="changeUserPwd">
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="">New Password</label>
                        <input type="password" placeholder="Enter New Password" id="newPassword" name="newPassword" class="form-control">
                        <span class="err" id="err_newPassword"></span>
                    </div>

                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Enter Confirm Password" class="form-control">
                         <span class="err" id="err_confirmPwd"></span>
                    </div>
                </div>
                 <div class="mt-4">
                <a href="javascript:void(0);" onclick="updateChangePwd()" class="search-btn">Update</a>
                <a href="javascript:void(0);" class="search-btn clear-btn" data-bs-dismiss="modal" onclick="cancelChangePwd()" >Cancel</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Ads</h5>
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
                    "visible":true
                },
                {
                    "aTargets": [0],
                    "mRender": function(data, type, full){
                      
                        return '<th scope="row"><a href="'+baseUrl+'/administrator/dashboard#advertisement_detail/'+full['id']+'" onclick="advertisementDetail('+full['id']+')"><i class="bi bi-chevron-right"></i></a></th> ';
                    }
                },
                {
                    "aTargets": [10],
                    "visible":false
                },
                {
                    "aTargets": [1],
                    "mRender": function(data, type, full){
                        var response ='' ;
                       
                        if(full['sponserIcon']!='' || full['sponserIcon']==undefined ){
                         response='<img src="'+full['sponserIcon']+'" width="50px" height="50px"  /> '+full['name'];
                        }else{
                          response=full['name'];   
                        }
                        return response ;
                    }
                }, {
                    "aTargets": [5],
                    "mRender": function(data, type, full){
                        var response ='' ;
                       
                        if((full['ads']!='' || full['ads']==undefined ) && full['adType']=='image'){
                         response='<img src="'+full['ads']+'" width="50px" height="50px" alt="Ads Not found" /> ';
                        }else if((full['ads']!='' || full['ads']==undefined ) && full['adType']=='video'){
                         response='<a href="'+full['ads']+'" download>Download</a> ';
                        }else{
                          response='';   
                        }
                        return response ;
                    }
                }
                
                ,{
                    "aTargets": [2],
                    "visible":false
                },
               
                {
                            "aTargets": [8],
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
                    "aTargets": [9],
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
                },   {
                    "aTargets": [10],
                     "mRender": function(data, type, full){
                        var response ='<td><div class="align-items-center d-flex"> <div class="more_n"> <i class="bi bi-three-dots-vertical" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink"> <li><a class="dropdown-item" href="javascript:void(0);" onclick="ConfirmDelete('+full['id']+')">Delete</a></li> <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#change_pass" onclick="changePassword('+full["id"]+')">Change Password</a></li> </ul> </div> ' ;

                        

                        response+=' </div> </td>'  ;

                        return response ;
                    }
                }
                ],

            ajax: {
                      url: '{!! URL::asset('adsDatatable') !!}',
                    },
             columns : [
             
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'sponserIcon' },
                        { data: 'title' },
                        { data: 'adType'},
                        { data: 'ads'},
                        { data: 'start_date'},  
                        { data: 'end_date'},
                        { data: 'status_'},                      
                        { data: 'status' }
          ],
         
        });

      $k('.input-group-addon').click(function() {
        $k(this).prev('input').focus();
    });
         

});


function submitNotifyFor(){

ajaxCsrf();


var sponser=$('#sponser_').val();
var adsTitle=$('#ads_title').val();
var adsType=$('#ads_type').val();
var startDate=$('#startDate').val();
var endDate=$('#endDate').val();
var adsFile =$('#adsFile').val();

$('.err').html('');

if(sponser==''){
 $('#err_sponser_').html('Please select sponser.');
}else if(adsTitle==''){
  $('#err_ads_title').html('Please enter ads title.');
}else if(adsType==''){
  $('#err_ads_type').html('Please select ads type.');
}else if(startDate==''){
  $('#err_startDate').html('Please select start date.');
}else if(endDate==''){
  $('#err_endDate').html('Please select end date.');
}else if(endDate < startDate){
  $('#err_endDate').html('Please select valid end date.');
}else if(adsFile==''){
  $('#err_adsFile').html('Please select ads file.');
} else {

   var formData=new FormData($('#fuelTypeForm')[0]);

     $.ajax({
       type: "POST",
       url: baseUrl + '/SaveAdvertisement',
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

$('#sponser_').val('');
$('#ads_title').val('');
$('#ads_type').val('');
$('#startDate').val('');
$('#endDate').val('');
$('#adsFile').val('');


}

function changeUsrStatus(id){

    ajaxCsrf();

    $.ajax({
        type:"POST",
        url:baseUrl+'/adsStatus',
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
  adsManagement();
     //$('#dataTable').DataTable().ajax.reload();        
  
}

function editNFor(updatedId){   

ajaxCsrf();
$('#edit_body').modal('show') ;
$.ajax({
    type: "POST",
    url: baseUrl +'/editAds',
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
    
var sponser=$('#edit_sponser_').val();
var adsTitle=$('#edit_ads_title').val();
var adsType=$('#edit_ads_type').val();
var startDate=$('#edit_startDate').val();
var endDate=$('#edit_endDate').val();
var adsFile =$('#edit_adsFile').val();
ajaxCsrf();
$('.err').html('');

if(sponser==''){
 $('#err_edit_sponser_').html('Please select sponser.');
}else if(adsTitle==''){
  $('#err_edit_ads_title').html('Please enter ads title.');
}else if(adsType==''){
  $('#err_edit_ads_type').html('Please select ads type.');
}else if(startDate==''){
  $('#err_edit_startDate').html('Please select start date.');
}else if(endDate==''){
  $('#err_edit_endDate').html('Please select end date.');
}else if(endDate < startDate){
  $('#err_edit_endDate').html('Please select valid end date.');
} else {


$('.err').html('');
var formData=new FormData($('#editFeatureForm')[0]);

$.ajax({
    type: "POST",
    url: baseUrl +'/updateAds',
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
      
        var status=$("#cust_status").val();
        var username=$("#username").val();
        //var email=$("#cus_email").val();
        var cName=$("#cust_name").val();
   
   
     if(status){
   
          $('#dataTable').DataTable().column(9).search(status).draw();
    }
   
    //  if(mobileNumber){
   
    //       $('#dataTable').DataTable().column(6).search(mobileNumber).draw();
    // }

     if(username){
   
          $('#dataTable').DataTable().column(3).search(username).draw();
    }

    if(cName){
   
          $('#dataTable').DataTable().column(1).search(cName).draw();
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
        url:baseUrl+'/adsDelete',
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