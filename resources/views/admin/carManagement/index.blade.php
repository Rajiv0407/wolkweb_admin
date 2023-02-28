   <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper d-flex align-items-center justify-content-between">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Car Management</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()" >Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Car Management</li>
                        </ol>
                    </nav>
                    <div class="rightButton">
                        <a href="javascript:void(0);" class="border-btn" data-bs-toggle="modal" data-bs-target="#addVehicle" onclick="addCar()"><i class="bi bi-plus"></i>Add Car</a>
                    </div>
                </div>
                <div class="filterWrapper">
                    <form action="javascript:void(0)" method="post" id="carManagement_search_form">
                    <div class="form filterWrapper__l">
                         <!--  -->
                        <div class="form-group">
                            <label for="Manufacture">Manufacture</label>
                            <input type="text" class="form-control" id="manufacture" placeholder="Manufacture">
                        </div>
                        <div class="form-group">
                            <label for="Model">Model</label>
                            <input type="text" class="form-control" id="model" placeholder="Model">
                        </div>
                        <!-- <div class="form-group">
                            <label for="oName">Name </label>
                            <input type="text" class="form-control" id="oName" placeholder="Name">
                        </div> -->
                        <div class="form-group">
                            <label for="oName">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="oName"> Mobile No.</label>
                            <input type="text" class="form-control" id="mobileNo" placeholder="Mobile No." >
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="cstm_icon_drpdwn"></div>
                            <select name="" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </div>
                        <div class="d-flex">
                            <a href="javascript:void(0);"  onclick="searchFormdata();" class="search-btn">
                                <i class="bi bi-search"></i><span>Search</span>
                            </a>
                            <a href="javascript:void(0);" class="search-btn clear-btn ml-5px" onclick="resetFormdata();">
                                <i class="bi bi-eraser-fill"></i><span>Clear</span>
                            </a>
                        </div>

                   <!--  </form> -->
                    </div>
                </form>
                </div>
                <div class="table-area">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Manufacture</th>
                            <th scope="col">Model</th>
                            <th scope="col">Price</th>
                            <th scope="col">Mobile No.</th>
                            <th scope="col">Email</th>
                            <th scope="col">Address</th>
                            <th scope="col">Status</th>
                            <th scope="col">Status_</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>

<!-- Add Car -->
<div class="modal fade right_side" id="addVehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout add_car_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Car</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" id="addCarModel">
                
            </div>
        </div>
    </div>
</div>


<!-- Edit Car -->
<div class="modal fade right_side" id="editVehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout edit_Car_mdl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Car</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" id="editVehicleModal">
                
                
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
      columnDefs: [  {
                    "aTargets": [0],
                    "mRender": function(data, type, full){
                      
                        return '<th scope="row"><a href="'+baseUrl+'/administrator/dashboard#car_detail/'+full['id']+'" onclick="carDetail('+full['id']+')"><i class="bi bi-chevron-right"></i></a></th> ';
                    }


                },{
                    "aTargets": [9],
                    "mRender": function(data, type, full){
                        var action = '<td> <div class="align-items-center d-flex"> <div class="more_n"><i class="bi bi-three-dots-vertical show" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="true"></i> <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" data-popper-placement="top-end" style="position: absolute; left: 0px; top: auto; margin: 0px; right: auto; bottom: 0px; transform: translate(1066px, -38px);"><li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editVehicle" onclick="editVehicle('+full['id']+')">Edit</a></li><li><a class="dropdown-item" onclick="ConfirmDelete('+full['id']+')" href="javascript:void(0);">Delete</a></li> </ul></div> <div> <label class="switch">' ;

                        if(full['vehicleStatus']=='1'){
                             action +='<input type="checkbox" onclick="changeCarStatus('+full['id']+')" checked>' ;
                            
                        }else{
                             action +='<input type="checkbox" onclick="changeCarStatus('+full['id']+')" >' ;
                           
                        }
                       
                       action+='<span class="slider"></span> </label> </div> </div> </td>'  ;

                       return action ;
                    }

                }
                ,
                {
                    "aTargets": [8],
                    "visible": false

                }

                ],

            ajax: {
                      url: '{!! URL::asset('carManagement/carData') !!}',
                    },
             columns : [
             
                        { data: 'id' },
                        { data: 'manufacturer' },
                        { data: 'model' },
                        { data: 'price' },
                        { data: 'number'},
                        { data: 'email' },
                        { data: 'Address' },
                        { data: 'status'} ,
                        { data: 'vehicleStatus'} 
         
        
          ],

        });
      $k('.input-group-addon').click(function() {
        $k(this).prev('input').focus();
    });
         
});






   function searchFormdata(){

        var manufacture=$("#manufacture").val();
        var email_id=$("#email").val();
        var model=$("#model").val();
        var status=$("#status").val();        
        var mobileNo=$("#mobileNo").val();



     if(manufacture){
     
          $('#dataTable').DataTable().column(1).search(manufacture).draw();
    }
     if(email_id){
    //  alert("email");
     // console.log(email_id);
          $('#dataTable').DataTable().column(5).search(email_id).draw();
    }
    if(model){
          $('#dataTable').DataTable().column(2).search(model).draw();
    }
    
    if(mobileNo){
          $('#dataTable').DataTable().column(4).search(mobileNo).draw();
    }
    if(status){
          $('#dataTable').DataTable().column(8).search(status).draw();
    }
}

function resetFormdata(){
  // 'dataTable','landlords_search_form'
    var table = $('#dataTable').DataTable();
    document.getElementById("carManagement_search_form").reset();
   carManagement();
    //   $('#dataTable').DataTable().ajax.reload();        
  
}

function changeCarStatus(id){
    ajaxCsrf();

    $.ajax({type:"POST",
    url:baseUrl+'/carManagement/changeStatus',
   data:{"id":id},
   dataType:'json',
  beforeSend:function()
{
},
success:function(res)
{

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
        delete_carManageMent(id);
    }
}

function delete_carManageMent(id){
     ajaxCsrf();
    $.ajax({type:"POST",
    url:baseUrl+'/carManagement/deleteRecord',
    data:{"id":id},
    dataType:'json',
    beforeSend:function()
    {
    },
    success:function(res)
    {

    if(res.status==1){
    //carManagement();
      $('#dataTable').DataTable().ajax.reload();                
      statusMesage('deleted successfully','success');
    }else{
       statusMesage('something went wrong','error');
    }
    }

    });

}



function addCar(){
   
     ajaxCsrf();


     $.ajax({type:"POST",
    url:baseUrl+'/carManagement/addCar',
    data:{},
   
    beforeSend:function()
    {
        ajax_before();
    },
    success:function(html)
    {
        ajax_success() ;
        $('#addCarModel').html(html);
    
    }
    });
}


function saveCar(){

     ajaxCsrf();

       var carManufacture=$('#car_manufacture').val() ;
       var carModel = $('#car_model').val() ;
       var carSeats = $('#car_seats').val() ;
       var carDoors = $('#car_doors').val() ;
       var carFuleType = $('#car_fuleType').val() ;
       var carTransType = $('#car_transmissionType').val() ;
       var carBodyType = $('#car_bodyType').val() ;
       var carPrice = $('#car_price').val() ;

       removeError();
       $('.err').html('');

       if(carManufacture==''){
         $('#err_manufacture').html('Please enter manufacturer');
       }else if(carModel==''){
        $('#err_car_model').html('Please enter model');
       }else if(carSeats==''){
        $('#err_car_seats').html('Please enter number of seats');
       }else if(carDoors==''){
        $('#err_car_doors').html('Please enter number of doors');
       }else if(carFuleType==''){
        $('#err_fuel_type').html('Please select fule type');
       }else if(carTransType==''){
        $('#err_trans_type').html('Please select transmission type');
       }else if(carBodyType==''){
         $('#err_body_type').html('Please select vehicle body type');
       }else if(carPrice==''){
         $('#err_price').html('Please enter price');
       }else{

        $('.err').html('');

            var formData = $('#addCarForm').serialize() ; //new FormData([0]);

            $.ajax({
            type:"POST",
            url:baseUrl+'/carManagement/saveCar',
            data:formData ,
            dataType:'json',

            beforeSend:function()
            {
            ajax_before();
            },
            success:function(html)
            {
              ajax_success() ;
             if(html.status==1){
                $('#addCarForm')[0].reset();
                $('#addVehicle').modal('hide');  
                $('.modal-backdrop').hide();            
                $('#dataTable').DataTable().ajax.reload();
                
                statusMesage('save car successfully','success');
             }else{
                 statusMesage('something went wrong','error') ;
             }
            
            }
            });

       }
}





 function editVehicle(vehicleId){

     ajaxCsrf();

     $.ajax({
        type:"POST",
        url:baseUrl+'/carManagement/editVehicle',
        data:{'vehicleId':vehicleId} ,
        beforeSend:function()
        {
        ajax_before();
        },
        success:function(html)
        {
          ajax_success() ;
           $('#editVehicleModal').html(html);
        
        }
        });

}

 </script>
   