       <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper d-flex align-items-center justify-content-between ">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Master</h3>
                        <ol class="breadcrumb">
                            
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()" >Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Master</li>
                            <li class="breadcrumb-item active" aria-current="page">Fuel Type</li>
                        </ol>
                    </nav>
                    <div class="rightButton">
                        <a href="#" class="border-btn d-flax" data-bs-toggle="modal" data-bs-target="#add_fuel"><i class="bi bi-plus"></i><span>Add Fuel Type</span></a>
                    </div>
                </div>
                <form action="javascript:void(0);" method="post" id="fuelTypeSearch">
                <div class="filterWrapper">
                     <!--  -->
                    <div class="form filterWrapper__l s_I">
                        
                         <div class="form-group">
                            <label for="Manufacture">Fuel Type</label>
                            <input type="text" class="form-control" id="fuelTypes_" placeholder="Fuel Type">
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
                            <a href="javascript:void(0);" class="search-btn clear-btn ml-5px" onclick="clearFuelType()">
                                <i class="bi bi-eraser-fill"></i><span>Clear</span>
                            </a>
                        </div>
                 
                    </div>
                </div>
                       </form>
                <div class="table-area fuel_table">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                 <th scope="col">Id</th>
                                <th scope="col">Fuel Type</th>
                                <th scope="col">Icon</th>
                                <th scope="col" >Status</th>
                                <th scope="col" >Action</th>

                            </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                    </table>
                    <!-- <div class="table-footer">
                        <p><span>Total Record</span>:<span>10</span></p>
                    </div> -->
                </div>
        

<div class="modal fade right_side" id="add_fuel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout add_fuel">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Fuel Type</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
            <form action="javascript:void(0);" method="post" id="fuelTypeForm">
           
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Fuel Type</label>
                         <input type="text" name="fuelType" id="fuelType"  class="form-control" placeholder="Fuel Type">
                         <span id="err_fuelType" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Icon</label>
                         <input type="file" name="icon_fuelType" id="icon_fuelType"  class="form-control" placeholder="Fuel Type">
                         <span id="err_icon_fuelType" class="err" style="color:red"></span>

                    </div>
                      <span style="color: red;">[Note: icon size = 54 x 54 ]</span>
                </div>
                <div class="mt-4">
                    <a href="javascript:void(0);"  onclick="submitFuel()" class="search-btn">Submit</a>
                    <a href="javascript:void(0);" onclick="cancelFuel()" class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
                </div>
             
            </form>
            </div>
        </div>
    </div>
</div>
<!--  Edit Fuel -->
<div class="modal fade right_side" id="edit_fuel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout fuel_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Fuel Type</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" id="editFuelMb">
            
            </div>
        </div>
    </div>
</div>


<!-- End Edit Fuel -->
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
                },{
                    "aTargets": [2],
                    "mRender": function(data, type, full){ 
                      var action='' ;
                      if(full['icon']!=''){
                       action='<img src="'+full['icon']+'"  />' ;   
                      }
                     
                      return action ;
                    }
                }, {
                  "aTargets": [3],
                     "mRender": function(data, type, full){ 
                      var action='';
                      var className='' ;

                      if(full['status']==1){
                        className='activeFuelType' ;
                      }else{
                        className='inactiveFuelType' ;
                      }

                      action+='<span class="'+className+'">'+full['status_']+'</span>';

                      return action ;
                     }
                }, {
                    "aTargets": [4],
                    "mRender": function(data, type, full){
                        var action = '<div class="align-items-center d-flex"> <div class="more_n"> <i class="bi bi-three-dots-vertical" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink"> <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_fuel" onclick="editFuel('+full["id"]+')" >Edit</a></li> <li><a class="dropdown-item" href="javascript:void(0);" onclick="ConfirmDelete('+full['id']+')" >Delete</a></li> </ul> </div> <div> <label class="switch">  ' ;

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
                      url: '{!! URL::asset('masterController/fuel_datatable') !!}',
                    },
             columns : [            
                        { data:'id' },
                        { data:'title' },
                        { data:'icon' },
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
        delete_fuelType(id);
    }
}

    function delete_fuelType(id){
             ajaxCsrf();
        $.ajax({type:"POST",
        url:baseUrl+'/fuelType/deleteRecord',
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



    function submitFuel(){
         ajaxCsrf();
        var fuelType=$('#fuelType').val();
        $('.err').html('');

        if(fuelType==''){
            $('#err_fuelType').html('Please enter fuel type.')
        } else {

            
             var formData=new FormData($('#fuelTypeForm')[0]);
              $.ajax({
                type: "POST",
                url: baseUrl + '/saveFuleType',
                data:formData ,
                 cache:false,
                  contentType:false,
                  processData:false,
                dataType:'json',
                cache: 'FALSE',
                beforeSend: function () {
                       ajax_before();
                },
                success: function(html){
                 ajax_success() ;
                    if(html.status==1){
                        $('#fuelTypeForm')[0].reset() ;
                        $('#add_fuel').modal('hide');  
                        $('.modal-backdrop').hide();            
                        removeModelOpen();
                        $('#dataTable').DataTable().ajax.reload();

                          statusMesage('Save fuel type successfully','success');

                      }else{
                           statusMesage('Please upload valid image dimainsion 54 x 54','error');
                          //statusMesage('something went wrong','error');
                      }
                
                        }
                    });   

        }
    }

    function cancelFuel(){

        $('#fuelType').val('');


    }

    function editFuel(updatedId){
       
        ajaxCsrf();

        $.ajax({
            type: "POST",
            url: baseUrl +'/editFuelType',
            data:{'updatedId':updatedId} ,
           
            cache: 'FALSE',
            beforeSend: function () {
                   ajax_before();
            },
            success: function(html){
             ajax_success() ;
               $('#editFuelMb').html(html) ;
            
                    }
            });   
    }

    function updateFuel(){

        var fuelTitle = $('#editFuelType').val() ;

        $('.err').html('');

        if(fuelTitle==''){
          $('#err_edit_fuelType').html("Please enter fuel type title.");
        }else {
  
     ajaxCsrf();
        var formData=new FormData($('#editFuelTypeForm')[0]);

        $.ajax({
            type: "POST",
            url: baseUrl +'/updateFuelType',
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
                
                              $('.modal-backdrop').hide();   
                        $('#dataTable').DataTable().ajax.reload();
                          statusMesage('Update fuel type successfully','success');
                          $('#edit_fuel').modal('hide');  
                           
             }else{

               statusMesage('Please upload valid image dimainsion 54 x 54','error');
                 //statusMesage('something went wrong','error');
             }
                    }
            });      
        }

    }

function changeFuelStatus(id){

    ajaxCsrf();

    $.ajax({
        type:"POST",
        url:baseUrl+'/fuelType/changeStatus',
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


function clearFuelType(){

    var table = $('#dataTable').DataTable();
    document.getElementById("fuelTypeSearch").reset();
  fuleTypeList();
     //$('#dataTable').DataTable().ajax.reload();        
  
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
</script>