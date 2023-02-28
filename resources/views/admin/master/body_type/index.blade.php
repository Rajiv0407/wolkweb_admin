          <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper d-flex align-items-center justify-content-between ">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Master</h3>
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()" >Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Master</li>
                            <li class="breadcrumb-item active" aria-current="page">Body Type</li>
                        </ol>
                    </nav>

                    <!--data-bs-toggle="modal" data-bs-target="#add_body"   -->
                    <div class="rightButton">
                        <a href="javascript:void(0);" onclick="showModal('add_body456')" class="border-btn d-flax" ><i class="bi bi-plus"></i><span>Add Body Type</span></a>
                    </div>
                </div>
                <form action="javascript:void(0);" method="post" id="fuelTypeSearch">
                <div class="filterWrapper">
                    <div class="form filterWrapper__l s_I">
                       
                         <div class="form-group">
                            <label for="Manufacture">Body Type</label>
                            <input type="text" class="form-control" id="fuelTypes_" placeholder="Body Type">
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
                <div class="table-area body_type_tble body_tble">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">Id </th>
                                <th scope="col">Body Type</th>
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
        


<div class="modal fade right_side" id="add_body456" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout add_body_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Body Type</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" method="post" id="fuelTypeForm">
           
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Body Type</label>
                         <input type="text" name="bodyType" id="bodyType"  class="form-control" placeholder="Body Type">
                         <span id="err_fuelType" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Icon</label>
                         <input type="file" name="bt_icon" id="bt_icon"  class="form-control" >
                         <span id="err_bt_icon" class="err" style="color:red"></span>
                    </div>
                     <span style="color: red ;">[Note: Icon size = 54 x 54 ]</span>
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

<div class="modal fade right_side" id="edit_body" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout edit_body_typ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Body Type</h5>
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
                            "visible": false
                        } ,
                        {
                            "aTargets": [3],
                            "mRender" : function(data, type, full){ 
                              var action='' ;
                               var className='' ;

                            if(full['status']==1){
                              className='activeBodyType' ;
                            }else{
                              className='inactiveBodyType' ;
                            }

                            action+='<span class="'+className+'">'+full['status_']+'</span>';

                            return action ;
                            }
                        } ,



                         {
                            "aTargets": [2],
                            "mRender" : function(data, type, full){ 
                              var action='';
                              if(full['icon']!=''){
                                action+='<img src="'+full['icon']+'"  />';

                              }
                              return action ;
                            }
                        } ,  {
                            "aTargets": [4],
                            "mRender" : function(data, type, full){

                                // data-bs-toggle="modal" data-bs-target="#edit_body"

                                var action = '<div class="align-items-center d-flex"> <div class="more_n"> <i class="bi bi-three-dots-vertical" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink"> <li><a class="dropdown-item" href="javascript:void(0);"  onclick="editFuel('+full["id"]+')" >Edit</a></li> <li><a class="dropdown-item" href="javascript:void(0);" onclick="ConfirmDelete('+full['id']+')" >Delete</a></li> </ul> </div> <div> <label class="switch">  ' ;

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
                              url: '{!! URL::asset('masterController/bType_datatable') !!}',
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
            delete_bodyType(id);
        }
    }

    function delete_bodyType(id){

             ajaxCsrf();

        $.ajax({

        type:"POST",
        url:baseUrl+'/deleteBodyType',
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



    function submitBType(){
         ajaxCsrf();
        var bodyType=$('#bodyType').val();
        $('.err').html('');

        if(bodyType==''){
            $('#err_fuelType').html('Please enter body type.')
        } else {

            var formData=new FormData($('#fuelTypeForm')[0]);

              $.ajax({
                type: "POST",
                url: baseUrl + '/saveBodyType',
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

                          statusMesage('Save body type successfully','success');
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
        $('#edit_body').modal('show') ;
        $.ajax({
            type: "POST",
            url: baseUrl +'/editBodyType',
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

    function updateBodyType(){
     
     var editType = $('#editFuelType').val();

     $('.err').html('');
     
     if(editType==''){
      $('#err_edit_fuelType').html('Please enter body type title.');
     }else{

     ajaxCsrf();

            var formData=new FormData($('#editFuelTypeForm')[0]);

          $.ajax({
            type: "POST",
            url: baseUrl +'/updateBodyType',
            data:formData ,
            dataType:'json',
            cache:false,
                  contentType:false,
                  processData:false,
            cache: 'FALSE',
            beforeSend: function () {
                   ajax_before();
            },
            success: function(html){
             ajax_success() ;
             if(html.status==1){

                 modalHide_('edit_body'); 
                // $('.modal-backdrop').hide();   
                $('#dataTable').DataTable().ajax.reload();
                statusMesage('Update body type successfully','success');
                // $('#edit_fuel').modal('hide');  
                           
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
        url:baseUrl+'/bodyType/changeStatus',
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


function clearBodyType(){

    var table = $('#dataTable').DataTable();
    document.getElementById("fuelTypeSearch").reset();
  bodyTypeList();
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