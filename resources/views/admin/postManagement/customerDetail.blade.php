<?php 

$userId=isset($userInfo->id)?$userInfo->id:'' ;
$name = isset($userInfo->name)?$userInfo->name:'' ;
$mobileNumber = isset($userInfo->mobile_Number)?$userInfo->mobile_Number:'' ;
$mobileCode = isset($userInfo->mobile_Code)?$userInfo->mobile_Code:'' ;
$email = isset($userInfo->email)?$userInfo->email:'' ;
$country = isset($userInfo->Country)?$userInfo->Country:'' ;
$state = isset($userInfo->State)?$userInfo->State:'' ;
$city = isset($userInfo->City)?$userInfo->City:'' ;
$zipcode = isset($userInfo->Zipcode)?$userInfo->Zipcode:'' ;
$houseNumber = isset($userInfo->House_Number)?$userInfo->House_Number:'' ;
$landMark = isset($userInfo->LandMark)?$userInfo->LandMark:'' ;
$address=userAddress($landMark,$houseNumber,$city,$state,$country,$zipcode);
$appImg = isset($userInfo->App_Image)?$userInfo->App_Image:'' ;
$imgPath = url('/').'/public/storage/profileImage/thumb/';

if($appImg!=''){
    $imgPath_=$imgPath.$appImg ;
}else{
    $imgPath_ = '' ;
}
     
 ?>

            <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Customer Detail</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard();">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#customer_management" onclick="customerManagement()">Customer Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $name ; ?></li>
                        </ol>
                    </nav>
                </div>
                <div class="carDetail__wrapper">
                    <div class="cd_if_1 filterWrapper">
                        <div>
                           @if($appImg!=''):
                            <img src="{{$imgPath_}}" alt="">
                            @else
                            <img src="{{URL::to('/')}}/public/admin/images/avtar_i.png" alt="">
                            @endif
                        </div>
                        <div class="ownerDetail">
                            <div class="c_D">
                                <h3><?php echo isset($userInfo->name)?$userInfo->name:'' ; ?></h3>
                                
                                <p><span>Mobile Number</span> : <span><?php echo $mobileCode." ".$mobileNumber ; ?></span></p>
                                <p><span>Email ID</span> : <span><?php echo $email ; ?></span></p>
                                <p><span>Address:</span> : <span><?php echo $address ; ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="c_Doc c_dtl">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="Details-tab" data-bs-toggle="tab" data-bs-target="#Details" type="button" role="tab" aria-controls="Details" aria-selected="true" onclick="carRentBooking('{{$userId}}',2,'Details')">Car Booking</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="Details" role="tabpanel" aria-labelledby="Details-tab">
                            
                        </div>
                    </div>
                </div>
        <!-- view image -->
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
        var userId ='<?php echo $userId ; ?>' ;
        carRentBooking(userId,2,'Details');
    });
</script>
