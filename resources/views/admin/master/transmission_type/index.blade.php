            <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper d-flex align-items-center justify-content-between ">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Master</h3>
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()" >Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Master</li>
                            <li class="breadcrumb-item active" aria-current="page">Transmission Type</li>
                        </ol>
                    </nav>
                    <!-- data-bs-toggle="modal" data-bs-target="#add_trans" -->
                    <div class="rightButton">
                        <a href="javascript:void(0);" onclick="addTransType()" class="border-btn d-flax" ><i class="bi bi-plus"></i><span>Add Transmission Type</span></a>
                    </div>
                </div>
                <form action="javascript:void(0);" method="post" id="fuelTypeSearch">
                <div class="filterWrapper">
                    <div class="form filterWrapper__l s_I">
                        
                         <div class="form-group">
                            <label for="Manufacture">Transmission Type</label>
                            <input type="text" class="form-control" id="fuelTypes_" placeholder="Transmission Type">
                        </div> 
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="" id="fuelStatus" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </div>
                        <div class="d-flex">
                            <a href="javascript:void(0);" onclick="searchFuelType();"  class="search-btn">
                                <i class="bi bi-search"></i><span>Search</span>
                            </a>
                            <a href="javascript:void(0);" class="search-btn clear-btn ml-5px" onclick="clearBodyType()">
                                <i class="bi bi-eraser-fill"></i><span>Clear</span>
                            </a>
                        </div>
                 
                    </div>
                </div>
                       </form>
                <div class="table-area transition_table">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Transmission Type</th>
                                <th scope="col" >Status</th>
                                <th scope="col" >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>Automatic</td>
                                <td width="100">Active</td>
                                <td width="100">
                                    <div class="align-items-center d-flex">
                                        <div class="more_n">
                                            <i class="bi bi-three-dots-vertical" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#add_trans">Edit</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#change_pass">Delete</a></li>
                                            </ul>
                                        </div>
                                        <div>
                                            <label class="switch">
                                                <input type="checkbox">
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                    
                </div>
        
<!-- add transmission  -->
<div class="modal fade right_side" id="add_trans" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout add_transmission">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Transmission Type</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" method="post" id="transmissionTypeForm">
           
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Transmission Type</label>
                         <input type="text" name="bodyType" id="bodyType"  class="form-control" placeholder="Transmission Type">
                         <span id="err_fuelType" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="javascript:void(0);"  onclick="submitBType()" class="search-btn">Submit</a>
                    <a href="javascript:void(0);" id="cancelBType" onclick="cancelFuel()" class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>

<!-- edit transmission type -->
<div class="modal fade right_side" id="edit_trans" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout edit_body_typ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Transmission Type</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body" id="editTransType">
                
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
                            "visible": false
                        } ,  
                        {
                            "aTargets": [2],
                            "mRender" : function(data, type, full){ 
                              var action='' ;
                               var className='' ;

                            if(full['status']==1){
                              className='activeTransType' ;
                            }else{
                              className='inactiveTransType' ;
                            }

                            action+='<span class="'+className+'">'+full['status_']+'</span>';

                            return action ;
                            }
                        } ,


                        {
                            "aTargets": [3],
                            "mRender" : function(data, type, full){

                                // data-bs-toggle="modal" data-bs-target="#edit_body"

                                var action = '<div class="align-items-center d-flex"> <div class="more_n"> <i class="bi bi-three-dots-vertical" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink"> <li><a class="dropdown-item" href="javascript:void(0);"  onclick="editTransmission('+full["id"]+')" >Edit</a></li> <li><a class="dropdown-item" href="javascript:void(0);" onclick="ConfirmDelete('+full['id']+')" >Delete</a></li> </ul> </div> <div> <label class="switch">  ' ;

                            if(full['status']==1){
                                 action +='<input type="checkbox" onclick="changeFuelStatus('+full['id']+')" checked>' ;
                             }else{
                                action +='<input type="checkbox" onclick="changeFuelStatus('+full['id']+')" >' ;
                             }

                              action+='<span class="slider"></span> </label> </div> </div> '  ;

                               return action ;
                            }

                        
                        }
                        
                        ],

                    ajax: {
                              url: '{!! URL::asset('masterController/transmission_datatable') !!}',
                            },
                     columns : [            
                                { data:'id' },
                                { data:'title' },
                                { data:'status_' },
                                { data:'status' }
                  ],

                });

              $k('.input-group-addon').click(function() {
                $k(this).prev('input').focus();
            });
                 
        });

 function ConfirmDelete(id) {
        
        if(confirm("Are you sure ?")) {
            delete_bodyType(id);
        }
    }

    function delete_bodyType(id){

             ajaxCsrf();

        $.ajax({

        type:"POST",
        url:baseUrl+'/deleteTransType',
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
      
          $('#dataTable').DataTable().ajax.reload();                
          statusMesage('Deleted successfully','success');
        }else{
           statusMesage('Something went wrong','error');
        }
        }

        });

    }


 function searchFuelType(){

        var fuelTypes=$("#fuelTypes_").val();
        var fuelStatus=$("#fuelStatus").val();

     if(fuelTypes){
     
          $('#dataTable').DataTable().column(1).search(fuelTypes).draw();
    }
     if(fuelStatus){
   
          $('#dataTable').DataTable().column(3).search(fuelStatus).draw();
    }
   
  }


function clearBodyType(){

    var table = $('#dataTable').DataTable();
    document.getElementById("fuelTypeSearch").reset();
 transmissionTypeList();
     //$('#dataTable').DataTable().ajax.reload();        
  
}

function changeFuelStatus(id){

    ajaxCsrf();

    $.ajax({
        type:"POST",
        url:baseUrl+'/transType/changeStatus',
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


   function submitBType(){

         ajaxCsrf();
        var bodyType=$('#bodyType').val();
        $('.err').html('');

        if(bodyType==''){
            $('#err_fuelType').html('Please enter transmission type.')
        } else {

            var formData = $('#transmissionTypeForm').serialize() ;
              $.ajax({
                type: "POST",
                url: baseUrl + '/saveTransmissionType',
                data:formData ,
                dataType:'json',
                cache: 'FALSE',
                beforeSend: function () {
                       ajax_before();
                },
                success: function(html){

                 ajax_success() ;

                    if(html.status==1){
                        $('#transmissionTypeForm')[0].reset();  
                        $('#add_trans').modal('hide'); 
                        $('.modal-backdrop').remove();    
                         removeModelOpen();
                        $('#dataTable').DataTable().ajax.reload();

                          statusMesage('Save transmission type successfully','success');
                      }else{
                          statusMesage('Something went wrong','error');
                      }
                
                        }
                    });   

        }
    }

    function addTransType(){
        $('#add_trans').modal('show');
    }

     function editTransmission(updatedId){
       // alert('hello');
       $('#edit_trans').modal('show');
        ajaxCsrf();

        $.ajax({
            type: "POST",
            url: baseUrl +'/editTransmission',
            data:{'updatedId':updatedId} ,
           
            cache: 'FALSE',
            beforeSend: function () {
                   ajax_before();
            },
            success: function(html){
             ajax_success() ;
               $('#editTransType').html(html) ;
            
                    }
            });   
    }

    function updateTrnasType(){
        
     ajaxCsrf();

        var formData = $('#transmissionTypeForm_').serialize() ;

        $.ajax({
            type: "POST",
            url: baseUrl +'/updateTransType',
            data:formData ,
            dataType:'json',
            cache: 'FALSE',
            beforeSend: function () {
                   ajax_before();
            },
            success: function(html){
             ajax_success() ;
             if(html.status==1){
                
                              $('.modal-backdrop').hide();   
                        $('#dataTable').DataTable().ajax.reload();
                          statusMesage('Update transmission type successfully','success');
                          $('#edit_trans').modal('hide');  
                           
             }else{
                 statusMesage('Something went wrong','error');
             }
              
            
                    }
            });      
    }
</script>