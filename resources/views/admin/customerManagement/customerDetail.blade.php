<?php 

$userId=isset($userInfo->id)?$userInfo->id:'' ;
$name = isset($userInfo->name)?$userInfo->name:'' ;
$mobileNumber = isset($userInfo->phoneNumber)?$userInfo->phoneNumber:'' ;
$email = isset($userInfo->email)?$userInfo->email:'' ;
$country = isset($userInfo->country)?$userInfo->country:'' ;
$point = isset($userInfo->rank_)?$userInfo->rank_:'' ;
$followers = isset($userInfo->followers)?$userInfo->followers:'' ;
$status = isset($userInfo->status)?$userInfo->status:'' ;

$appImg = isset($userInfo->image)?$userInfo->image:'' ;
$imgPath = url('/').'/public/admin/images/avtar_i.png';

if($appImg!=''){
    $imgPath_=$appImg ;
}else{
    $imgPath_ = $imgPath ;
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
                                <p><span>Email ID</span> : <span><?php echo $email ; ?></span></p>
                                <p><span>Mobile Number</span> : <span><?php echo $mobileNumber ; ?></span></p>
                                <p><span>Country:</span> : <span><?php echo $country ;  ?></span></p>
                                <p><span>Point:</span> : <span><?php echo $point ;  ?></span></p>
                                <p><span>Followers:</span> : <span><?php echo $followers ;  ?></span></p>
                                <p><span>Status:</span> : <span><?php echo $status ;  ?></span></p>
                                <p><span>Interest:</span> : <span><?php echo $userInterest ;  ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="c_Doc c_dtl">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="Details-tab" data-bs-toggle="tab" data-bs-target="#Details" type="button" role="tab" aria-controls="Details" aria-selected="true" onclick="userHostListing('{{$userId}}',2,'Details')">Host</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="Advertisement-tab" data-bs-toggle="tab" data-bs-target="#Advertisement" type="button" role="tab" aria-controls="Advertisement" aria-selected="true" onclick="userHostListing('{{$userId}}',3,'Advertisement')" >Advertisement</button>
                        </li>   
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers" type="button" role="tab" aria-controls="followers" aria-selected="true" onclick="userHostListing('{{$userId}}',1,'followers')" >Followers</button>
                        </li>  
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="follows-tab" data-bs-toggle="tab" data-bs-target="#follows" type="button" role="tab" aria-controls="follows" aria-selected="true" onclick="userHostListing('{{$userId}}',4,'follows')" >Follows</button>
                        </li>                       
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="Details" role="tabpanel" aria-labelledby="Details-tab">
                            
                        </div>
                        <div class="tab-pane fade show" id="Advertisement" role="tabpanel" aria-labelledby="Advertisement-tab">
                            Advertisement
                        </div>
                        <div class="tab-pane fade show" id="followers" role="tabpanel" aria-labelledby="followers-tab">
                            Followers
                        </div>
                        <div class="tab-pane fade show" id="follows" role="tabpanel" aria-labelledby="follows-tab">
                            Follows
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
      
        userHostListing(userId,2,'Details');
    });
</script>
