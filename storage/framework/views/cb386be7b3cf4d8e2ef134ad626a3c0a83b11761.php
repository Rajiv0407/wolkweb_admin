
<form class="" id="n_serarchForm" action="javascript:void(0);" > 
                <div class="filterWrapper">
                    <div class="form filterWrapper__l">
                        <div class="form-group">
                            <label for="Manufacture">Sponser Name</label>
                            <input type="text" class="form-control" placeholder="Sponser Name" id="user_name_">
                        </div>
                        <div class="form-group">
                            <label for="Model">Title</label>
                            <input type="text" class="form-control" id="comment_" placeholder="Title">
                        </div>  
                        <!-- <div class="form-group">
                            <label for="oName">Mobile Number</label>
                            <input type="text" class="form-control" id="cus_mobileNumber" placeholder="Mobile Number">
                        </div> -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="" id="comment_status_" class="form-control">
                                <option value="">Select</option>
                                <option value="1">Approved</option>
                                <option value="0">Pending</option>
                                <option value="2">Rejected</option>
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
                                            <th scope="col">Sponser</th>                                                                               
                                            <th scope="col">Title</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Logo</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">End Date</th>
                                            <th scope="col">IsAccept</th>
                                            <th scope="col">CreatedOn</th>
                                            <th scope="col">IsAccept_</th>
                                            <th scope="col">Adv_type</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                      
                                         
                                    </tbody>
                                </table>
                              
                            </div>
<!-- Edit Model -->
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
                "visible":false
            },{
                "aTargets": [9],
                "visible":false
            },
            {
                "aTargets": [10],
                "visible":false
            },
            {
                            "aTargets": [7],
                            "mRender" : function(data, type, full){ 
                              var action='' ;
                               var className='' ;

                            if(full['isAccept_']==1){
                              className='activeNFor' ;
                            }else if(full['isAccept_']==2){
                              className='inactiveNFor' ;
                            }else{
                              className='' ;
                            }

                            action+='<span class="'+className+'">'+full['isAccept']+'</span>';

                            return action ;
                            }
                        } ,  
            {
                    "aTargets": [4],
                     "mRender": function(data, type, full){
                       var response='' ;
                        if(full['adv_type_']==1){
                            response='<img src="'+full['image']+'" width="60px" height="60px" />' ;
                        }else if(full['adv_type_']==2){
                            response='<a href="'+full['image']+'" download>Dwonload</a>' ;
                        }
                       
                        return response ;
                    }
                },
                        {
                    "aTargets": [11],
                     "mRender": function(data, type, full){
                        var response ='<td><div class="align-items-center d-flex"><div class="more_n"> <i class="bi bi-three-dots-vertical" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink"><li><a class="dropdown-item" href="javascript:void(0);"  onclick="editNFor('+full["id"]+')" >Edit</a></li><li><a class="dropdown-item" href="javascript:void(0);" onclick="ConfirmDelete('+full['id']+')">Delete</a></li>  </ul> </div>  <div> <label class="switch">' ;
                        
                                  
                        if(full['isAccept_']=='1'){
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
                      url: '<?php echo URL::asset('userAdv_datatable/'.$userId.'/'.$type); ?>',
                    },
             columns : [
   
                        { data: 'id' },
                        { data: 'name' },                        
                        {data: 'title'},
                        {data: 'adv_type'},
                        {data: 'image'},
                        {data: 'start_date'},
                        {data: 'end_date'},
                        {data: 'isAccept'},
                        { data: 'createdOn' },
                        { data: 'isAccept_' },
                        { data: 'adv_type_' }
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
 
        $('#dataTable').DataTable().column(9).search(status).draw();
  }
 
  //  if(mobileNumber){
 
  //       $('#dataTable').DataTable().column(6).search(mobileNumber).draw();
  // }

   if(userName){
       
        $('#dataTable').DataTable().column(1).search(userName).draw();
  }

  if(comment){
 
        $('#dataTable').DataTable().column(2).search(comment).draw();
  }

 
}

function resetSearchForm(){

var table = $('#dataTable').DataTable();
document.getElementById("n_serarchForm").reset();
$('#dataTable').DataTable().columns().search("").ajax.reload();  
//hostListing('<?php //echo $userId ; ?>');   
 //$('#dataTable').DataTable().ajax.reload();        

}

function changeUsrStatus(id){

ajaxCsrf();

$.ajax({
    type:"POST",
    url:baseUrl+'/userAdvStatus',
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
        url:baseUrl+'/deleteUserAdv',
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

    function editNFor(updatedId){   

ajaxCsrf();
$('#edit_body').modal('show') ;
$.ajax({
    type: "POST",
    url: baseUrl +'/editUserAds',
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


</script><?php /**PATH D:\xampp\htdocs\walkofwebAdmin\walkofweb_admin\resources\views/admin/customerManagement/advertisement.blade.php ENDPATH**/ ?>