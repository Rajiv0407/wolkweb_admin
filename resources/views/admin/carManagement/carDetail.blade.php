<?php   
//print_r($carInfo) ; ?>

            <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">{{$carInfo->manufacturer }}</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#car_management" onclick="carManagement()">Car Management </a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$carInfo->manufacturer }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="carDetail__wrapper">
                    <div class="carDetail__content">
                        <div>
                            <!-- //{{URL::to('/')}}/public/admin/images/car.png -->
                            @if($carInfo->featuredImg!='')
                            <img src="{{$carInfo->featuredImg}}" alt="" id="vehicleFImg" width="80px" height="80px">
                            @endif
                        </div>
                        <div class="ownerDetail">
                            <div class="c_D">
                                <h3>Car Details</h3>
                                <p><span>Manufacture</span> : <span>{{ $carInfo->manufacturer }}</span></p>
                                <p><span>Model</span> : <span>{{$carInfo->model }}</span></p>
                                <p><span>Car Price</span> : <span>{{$carInfo->price }} AED</span></p>
                            </div>
                            <div class="o_D">
                                <h3>Owner Details</h3>
                                <div class="o_C">
                                    <p><span>Name</span> : <span>{{$carInfo->name }}</span></p>
                                    <p><span>Mobile Number</span> : <span>{{$carInfo->number }}</span></p>
                                    <p><span>Email Id</span> : <span>{{$carInfo->email }}</span></p>
                                    <p><span>Address</span> : <span>{{$carInfo->Address }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="c_Doc">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="Details-tab" data-bs-toggle="tab" data-bs-target="#Details" type="button" role="tab" aria-controls="Details" aria-selected="true" onclick="carBasicDetail('{{$vehicleId}}')">Car Details</button>

                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="Images-tab" data-bs-toggle="tab" data-bs-target="#Images" type="button" role="tab" aria-controls="Images" aria-selected="false" onclick="carImage('{{$vehicleId}}')">Car Images</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="Rent-tab" data-bs-toggle="tab" data-bs-target="#Rent" type="button" role="tab" aria-controls="Rent" aria-selected="false" onclick="carRentBooking('{{$vehicleId}}',1,'Rent')">Rent Booking</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="Rating-tab" data-bs-toggle="tab" data-bs-target="#Rating" type="button" role="tab" aria-controls="Rating" aria-selected="false" onclick="carRatingReview('{{$vehicleId}}')">Rating & Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="Details" role="tabpanel" aria-labelledby="Details-tab">
                       
                            
                        </div>

                        <div class="tab-pane fade" id="Images" role="tabpanel" aria-labelledby="Images-tab">
                            
                        </div>
                        <div class="tab-pane fade" id="Rent" role="tabpanel" aria-labelledby="Rent-tab">
                            
                        </div>
                        <div class="tab-pane fade" id="Rating" role="tabpanel" aria-labelledby="Rating-tab">
                        </div>
                    </div>
                </div>

<!-- Edit basic Detail -->
                <div class="modal fade right_side" id="editDetailVehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout edit_Car_mng">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Basic Details</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" id="editBasicDetail">
                
                
            </div>
        </div>
    </div>
</div>

<!-- Add Features Modal -->
<div class="modal fade right_side" id="edit_features" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout update_fet_Car_mng">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Features</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" id="addFeatureVehicle">
                
                
            </div>
        </div>
    </div>
</div>

<!--  upload Image  -->
<div class="modal fade right_side" id="uploadvehicleImage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout edit_body_typ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Vehicle Image</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

    <div class="modal-body" id="uploadVehicleImg_">
        <form action="javascript:void(0);" method="post" id="uploadVImg">
            
        <input type="hidden" name="vehicleId" id="vehicleId" value="{{$vehicleId}}">
            <div class="modal-form form">

            <div class="form-group">
            <label for="">Upload Image</label>
            <input type="file" class="form-control" name="vehicleImg" id="vehicleImg" placeholder="Vehicle Image">
            <span id="err_vehicleImg" class="err" style="color:red"></span>
            </div>

            </div>
                <div class="mt-4">
                    <a href="javascript:void(0);" onclick="uploadVehicleImg('{{$vehicleId}}')" class="search-btn" >Submit</a>
                    <a href="javascript:void(0);" class="search-btn clear-btn" data-bs-dismiss="modal" onclick="cancelForm('uploadVImg');">Cancel</a>
                </div>
         </form>
                
                
            </div>
        </div>





        
    </div>
</div>
<!-- car image view  -->
<div class="modal fade right_side" id="view_img" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Car Images</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" id="vehicleIdModal">
                
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

 $(document).ready(function(){
    var vehicleId='<?php echo $vehicleId ; ?>' ;
    carBasicDetail(vehicleId) ;

 })

    function carImage(id){
         ajaxCsrf();

        $.ajax({type:"POST",
        url:baseUrl+'/carManagement/carImage',
        data:{"vehicleId":id},
       
        beforeSend:function()
        {
            ajax_before();
        },
        success:function(html)
        {
            ajax_success() ;
            $('#Images').html(html);
           
        
        }
        });
    }

    
   

    function updateVehicleDesc(vId){

         ajaxCsrf();
       var formData = $('#updateDescriptionForm').serialize() ; //new FormData([0]);
        $.ajax({type:"POST",
        url:baseUrl+'/carManagement/updateDescription',
        data:formData,
        dataType:'json',
        beforeSend:function()
        {
            ajax_before();
        },
        success:function(html)
        {
            ajax_success() ;
          if(html.status==1){
             statusMesage('description updated successfully','success');
          }else{
             statusMesage('something went wrong','error');
          }
        
        }

        });
    }

function editDetailVehicle(vehicleId){

     ajaxCsrf();

     $.ajax({
        type:"POST",
        url:baseUrl+'/carManagement/editVehicle',
        data:{'vehicleId':vehicleId,'type':1} ,
        beforeSend:function()
        {
        ajax_before();
        },
        success:function(html)
        {
          ajax_success() ;
           $('#editBasicDetail').html(html);
        
        }
        });

}

function updateDetailCar(){
 
     ajaxCsrf();
            var carManufacture=$('#car_manufacture').val() ;
       var carModel = $('#car_model').val() ;
       var carSeats = $('#car_seats').val() ;
       var carDoors = $('#car_doors').val() ;
       var carFuleType = $('#car_fuleType').val() ;
       var carTransType = $('#car_transmissionType').val() ;
       var carBodyType = $('#car_bodyType').val() ;
       var carPrice = $('#car_price').val() ;
       var updatedId  = $('#updatedId').val() ;
       removeError();
       if(carManufacture==''){
         $('#err_manufacture').html('Please enter manufacturer');
       }else if(carModel==''){
        $('#err_car_model').html('Please enter manufacturer');
       }else if(carSeats==''){
        $('#err_car_seats').html('Please enter manufacturer');
       }else if(carDoors==''){
        $('#err_car_doors').html('Please enter manufacturer');
       }else if(carFuleType==''){
        $('#err_fuel_type').html('Please enter manufacturer');
       }else if(carTransType==''){
        $('#err_trans_type').html('Please enter manufacturer');
       }else if(carBodyType==''){
         $('#err_body_type').html('Please enter manufacturer');
       }else if(carPrice==''){
         $('#err_price').html('Please enter manufacturer');
       }else{
         var formData = $('#editCarForm').serialize() ;
         $.ajax({
            type:"POST",
            url:baseUrl+'/carManagement/updateVehicle',
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
                
                $('#editDetailVehicle').modal('hide');  
                $('.modal-backdrop').hide();            
                              
                statusMesage('updated successfully','success');
                carDetail(updatedId);
               //carBasicDetail(updatedId);
             }else{
                 statusMesage('something went wrong','error') ;
             }
            
            }
            });
   }
}


function editFeature(vehicleId){

     ajaxCsrf();
    
  $.ajax({
    type:"POST",
    url:baseUrl+'/carManagement/addFeature',
    data:{'vehicleId':vehicleId} ,
    beforeSend:function()
    {
    ajax_before();
    },
    success:function(html)
    {
      ajax_success() ;
       $('#addFeatureVehicle').html(html) ;
    
    }
    });

  
}

// function validateFeatureForm(i) {
//     var radios = document.getElementsByName("feature_title"+i);
//     var formValid = false;

//     var i = 0;
//     while (!formValid && i < radios.length) {
//         if (radios[i].checked) formValid = true;
//         i++;        
//     }

//     if (!formValid)  
//       statusMesage('Must check some option!','error') ;
//     return formValid;
// }​

function updateVehicleFeature(vehicleId){
     ajaxCsrf();
  
      var formData = $('#addFeatureForm').serialize() ; //new FormData([0]);

     $.ajax({
    type:"POST",
    url:baseUrl+'/carManagement/updateVFeature',
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
                
                $('#edit_features').modal('hide');  
                $('.modal-backdrop').hide();            
                          
                statusMesage('updated successfully','success');
                carDetail(vehicleId);
               //carBasicDetail(updatedId);
             }else{
                 statusMesage('something went wrong','error') ;
             }
    
    }
    });

}

function removeVehicleImg(imgId,vehicleId,isFeatured){
     
   if(confirm("Are you sure ?")) {
        delete_carImage(imgId,vehicleId,isFeatured);
    }
}

function delete_carImage(imgId,vehicleId,isFeatured){

  ajaxCsrf();

   $.ajax({
    type:"POST",
    url:baseUrl+'/carManagement/deleteCarImg',
    data:{'imgId':imgId,'vehicleId':vehicleId,'isFeatured':isFeatured} ,
    dataType:'json',
    beforeSend:function()
    {
    ajax_before();
    },
    success:function(html)
    {
      ajax_success() ;
        console.log(html);

        if(html.status==1){
            
            var isFeatured_ = html.data.isFeatured ;

              if(isFeatured_==1){

                var imgUrl = html.data.imageUrl ;
                $("#vehicleFImg").attr("src",imgUrl);  
              }
            statusMesage('deleted successfully','success');
            carImage(vehicleId);         
         }else{
             statusMesage('something went wrong','error') ;
         }
    
    }
    });

}

function validateVImage(){
     var fileInput = document.getElementById('vehicleImg');
     var filePath = fileInput.value ;
        $('.err').html('');
   
 
    if(filePath==''){
         $('#err_vehicleImg').html("please select image") ;
        return false;
    }
            // Allowing file type
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.PNG|\.JPG|\.JPEG)$/i;

    if (!allowedExtensions.exec(filePath)) {
        //alert('Invalid file type');
        $('#err_vehicleImg').html("please select valid image type") ;
        fileInput.value = '';
        return false;
    } 
}

function uploadVehicleImg(vehicleId){
   
      if(validateVImage()==false){
        return false ;
      }
      ajaxCsrf();

    var formData=new FormData($('#uploadVImg')[0]);

  $.ajax({
    type:"POST",
    url:baseUrl+'/carManagement/uploadVImg',
    data:formData ,
    cache:false,
    contentType:false,
    processData:false,
    dataType:'json',
    beforeSend:function()
    {
    ajax_before();
    },
    success:function(html)
    {
        
      ajax_success() ;
        if(html.status==1){
            $('#uploadVImg')[0].reset();
            if(html.data.isFeatured==1){
              // alert(html.data.carImg) ;
              
               $('#vehicleFImg').attr("src", html.data.carImg);
            }
            modalHide('uploadvehicleImage');  
            statusMesage('image uploaded successfully','success');
            carImage(vehicleId);         
         }else{
             statusMesage('something went wrong','error') ;
        } 
    }
    
    });
}

function addFeaturedImg(imgId,vehicleId,carImg){
   
    $.ajax({
    type:"POST",
    url:baseUrl+'/carManagement/addFeaturedImg',
    data:{'imgId':imgId,'vehicleId':vehicleId} ,
    dataType:'json',
    beforeSend:function()
    {
    ajax_before();
    },
    success:function(html)
    {
        
      ajax_success() ;
        if(html.status==1){
           
            $("#vehicleFImg").attr("src",carImg);
             statusMesage('change feature image successfully','success');
            //carImage(vehicleId);         
         }else{
             statusMesage('something went wrong','error') ;
         }
    
    }
    });
}

</script>
        