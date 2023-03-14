
            <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper d-flex align-items-center justify-content-between" >
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Notifications</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Notification</li>
                        </ol>
                    </nav>
                    <!-- data-bs-toggle="modal" data-bs-target="#addNotificationModal"  -->
                    <div class="rightButton">
                        <a href="javascript:void(0);" class="border-btn" onclick="addNotification()"><i class="bi bi-plus"></i>Add Notification</a>
                    </div>
                </div>

<form class="" id="n_serarchForm" action="javascript:void(0);" > 
                <div class="filterWrapper">

                    <div class="form filterWrapper__l">
                        
                        <div class="form-group">
                            <label for="Manufacture">Device Type</label>
                            <select name="s_deviceType" id="s_deviceType" class="form-control">
                                <option value="">Select</option>
                                <option value="android">Android</option>
                                <option value="ios">Ios</option>
                                <option value="both">Both</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Model">Notification Type</label>
                            <select name="s_nType" id="s_nType" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($nType as $key => $value): ?>
                                    <option value="<?php echo $value->title ; ?>"><?php echo $value->title ; ?></option>
                                <?php endforeach ?>
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="oName">Title</label>
                            <input type="text" name="s_title" id="s_title" value="" placeholder="Title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="s_status" id="s_status" class="form-control">
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </div>
                        <div class="d-flex">
                            <a href="javascript:void(0);"  onclick="searchNType()" class="search-btn">
                                <i class="bi bi-search"></i><span>Search</span>
                            </a>
                            <a href="javascript:void(0);" onclick="resetSearchForm()" class="search-btn clear-btn ml-5px">
                                <i class="bi bi-eraser-fill"></i><span>Clear</span>
                            </a>
                        </div>
                        
                    </div>
                </div></form>
                <div class="table-area notification_mng_tbl">
                    <table class="table" id="dataTable">
                        <thead>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Device For</th>
                            <th>Notification Type</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                    <!-- <div class="table-footer">
                        <p><span>Total Record</span>:<span>10</span></p>
                    </div> -->
                </div>
        

<!-- Add notification  -->
<div class="modal fade right_side" id="addNotificationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout add_motification_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Notification</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" id="addNotificationMb">
                
            </div>
        </div>
    </div>
</div>

<!-- end add notification -->

<!-- Edit notification  -->
<div class="modal fade right_side" id="editNotificationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout edit_body_typ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Notification</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" id="EditNotificationMb">
                
            </div>
        </div>
    </div>
</div>
<!-- end edit notification -->



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
      columnDefs: [  {
                    "aTargets": [0],
                    "mRender": function(data, type, full){
                  
                        return '<th scope="row"><a href="'+baseUrl+'/administrator/dashboard#notification_detail/'+full['id']+'" onclick="notificationDetail('+full['id']+')"><i class="bi bi-chevron-right"></i></a></th> ';
                    }


                }, {
                  "aTargets": [5],
                     "mRender": function(data, type, full){ 
                      var action='';
                      var className='' ;

                      if(full['status']==1){
                        className='activeNotification' ;
                      }else{
                        className='inactiveNotification' ;
                      }

                      action+='<span class="'+className+'">'+full['status_']+'</span>';

                      return action ;
                     }
                },
                //  {
                //      "aTargets": [1],
                //     "mRender": function(data, type, full){
                  
                //         return '<div> <p class="mb-1">'+full["title"]+'</p> <span class="bg_an">'+full["nType"]+'</span> </div> ';
                //     }

                // },
                {
                     "aTargets": [4],
                    "mRender": function(data, type, full){
                  
                        return full['nType'];
                    }

                },
                {
                     "aTargets": [6],
                    "visible": false
                },
                {
                     "aTargets": [7],
                    "visible": true
                },
               {
                    "aTargets": [7],
                    "mRender": function(data, type, full){

                        // data-bs-toggle="modal" data-bs-target="#editVehicle"

                        var action = '<td> <div class="align-items-center d-flex"> <div class="more_n"><i class="bi bi-three-dots-vertical show" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="true"></i> <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" data-popper-placement="top-end" style="position: absolute; left: 0px; top: auto; margin: 0px; right: auto; bottom: 0px; transform: translate(1066px, -38px);"><li><a class="dropdown-item" href="javascript:void(0);"  onclick="editNotification('+full['id']+')">Edit</a></li><li><a class="dropdown-item" onclick="ConfirmDelete('+full['id']+')" href="javascript:void(0);">Delete</a></li> </ul></div> <div> <label class="switch">' ;

                        if(full['status']=='1'){
                             action +='<input type="checkbox" onclick="changeNStatus('+full['id']+')" checked>' ;
                            
                        }else{
                             action +='<input type="checkbox" onclick="changeNStatus('+full['id']+')" >' ;
                             
                           
                        }
                       
                       action+='<span class="slider"></span> </label> </div> </div> </td>'  ;

                       return action ;
                    }

                }

                ],

            ajax: {
                url:'{!! URL::asset('notify_datatable') !!}',
                    },
             columns : [            
                        { data: 'id' },
                        { data: 'title' },
                         { data: 'content'},
                          { data: 'deviceType' },                         
                        { data: 'status_' },
                        { data: 'status'} ,  
                        { data: 'nType' }                
                
          ],

        });
      $k('.input-group-addon').click(function() {
        $k(this).prev('input').focus();
    });
         
});

 function addNotification(){

        $('#addNotificationModal').modal('show');
         ajaxCsrf();
        $.ajax({
            type: "POST",
            url: baseUrl+'/addNotify',
            cache: 'FALSE',
            beforeSend: function () {
            ajax_before();
            },
            success: function(html){
            ajax_success() ;
            $('#addNotificationMb').html(html);
           }

        });

    }

function saveNotification(){
    
    var title = $('#notify_title').val();
    var nType = $('#nType').val(); 
    //var nFor = $('#nFor').val(); 
    var nDesc = $('#nDescription').val(); 

    $('.err').html('');

     if(title==''){
        $('#err_notify_title').html("Please enter title");
     }else if(nType==''){
        $('#err_nType').html("Please select notification type.");
     }
    //  else if(nFor==''){
    //     $('#err_nFor').html("Please select notification for.");
    //  }
     else if(nDesc==''){
         $('#err_nDescription').html("Please enter description .");
     } else {

      ajaxCsrf();
            var formData = $('#addNotifyForm').serialize()  ;
        $.ajax({
            type: "POST",
            url: baseUrl+'/saveNotify',
            data: formData ,
            cache: 'FALSE',
            dataType:'json',
            beforeSend: function () {
            ajax_before();
            },
            success: function(html){
            ajax_success() ;
            if(html.status==1){

            $('.modal-backdrop').hide();   
            $('#dataTable').DataTable().ajax.reload();
            statusMesage('Save notification successfully','success');
            $('#addNotificationModal').modal('hide');  

            }else{
            statusMesage('Something went wrong','error');
            }

            }

        });
   
     }

}


function editNotification(id){

           $('#editNotificationModal').modal('show');

         ajaxCsrf();

        $.ajax({
            type: "POST",
            url: baseUrl+'/editNotify',
            data:{'updatedId':id},
            cache: 'FALSE',
            beforeSend: function () {
            ajax_before();
            },
            success: function(html){
            ajax_success() ;
            $('#EditNotificationMb').html(html);
            }

        });

}

function updateNotification(){

    var title = $('#notify_title').val();
    var nType = $('#nType').val(); 
    var nFor = $('#nFor').val(); 
    var nDesc = $('#nDescription').val(); 

    $('.err').html('');

     if(title==''){
        $('#err_notify_title').html("Please enter title");
     }else if(nType==''){
        $('#err_nType').html("Please select notification type.");
     }else if(nFor==''){
        $('#err_nFor').html("Please select notification for.");
     }else if(nDesc==''){
         $('#err_nDescription').html("Please enter description .");
     } else {

    
         ajaxCsrf();
         
         var formData = $('#editNotifyForm').serialize()  ;

        $.ajax({
            type: "POST",
            url: baseUrl+'/updateNotify',
            data:formData ,
            cache: 'FALSE',
            dataType:'json',
            beforeSend: function () {
            ajax_before();
            },
            success: function(html){
            ajax_success() ;

           if(html.status==1){

            $('.modal-backdrop').hide();   
            $('#dataTable').DataTable().ajax.reload();
            statusMesage('Update notification successfully','success');
            $('#editNotificationModal').modal('hide');  

            }else{
            statusMesage('Something went wrong','error');
            }


            }

        });

    }

}

function ConfirmDelete(id) {
    
    if(confirm("Are you sure ?")) {
        delete_notification(id);
    }
}

    function delete_notification(id){
             ajaxCsrf();
        $.ajax({type:"POST",
        url:baseUrl+'/delete_announced_list',
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

function changeNStatus(id){

    ajaxCsrf();

    $.ajax({
        type:"POST",
        url:baseUrl+'/announce_Status',
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
     statusMesage('Changed status successfully','success');
  }else{
     statusMesage('Something went wrong','success');
  }
}

});
}


function resetSearchForm(){

    var table = $('#dataTable').DataTable();
    document.getElementById("n_serarchForm").reset();
  notificationList()();
     $('#dataTable').DataTable().ajax.reload();        
  
}



  function searchNType(){

        var deviceType=$("#s_deviceType").val();
        var status=$("#s_status").val();
        var title=$("#s_title").val();
        var nType=$("#s_nType").val();
   

     if(deviceType){
     
          $('#dataTable').DataTable().column(3).search(deviceType).draw();
    }

     if(status){
   
          $('#dataTable').DataTable().column(5).search(status).draw();
    }
   
     if(title){
   
          $('#dataTable').DataTable().column(1).search(title).draw();
    }

     if(nType){
   
          $('#dataTable').DataTable().column(6).search(nType).draw();
    }

   
}
   


</script>
