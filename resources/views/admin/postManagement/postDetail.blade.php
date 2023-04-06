<?php 

//$userId=isset($userInfo->id)?$userInfo->id:'' ;
$name = isset($post->name)?$post->name:'' ;
$message = isset($post->message)?$post->message:'' ;
$status = isset($post->status)?$post->status:'' ;
$createdOn = isset($post->createdOn)?$post->createdOn:'' ;
// $country = isset($userInfo->Country)?$userInfo->Country:'' ;
// $state = isset($userInfo->State)?$userInfo->State:'' ;
// $city = isset($userInfo->City)?$userInfo->City:'' ;
// $zipcode = isset($userInfo->Zipcode)?$userInfo->Zipcode:'' ;
// $houseNumber = isset($userInfo->House_Number)?$userInfo->House_Number:'' ;
// $landMark = isset($userInfo->LandMark)?$userInfo->LandMark:'' ;
// $address='' ; //userAddress($landMark,$houseNumber,$city,$state,$country,$zipcode);
// $appImg = isset($userInfo->App_Image)?$userInfo->App_Image:'' ;
// $imgPath = url('/').'/public/storage/profileImage/thumb/';

// if($appImg!=''){
//     $imgPath_=$imgPath.$appImg ;
// }else{
//     $imgPath_ = '' ;
// }
     
 ?>

            <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Post Detail</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard();">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#customer_management" onclick="customerManagement()">Customer Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Amit<?php //echo $name ; ?></li>
                        </ol>
                    </nav>
                </div>
                <div class="carDetail__wrapper">
                    <div class="filterWrapper">
                        <!-- <div>
                      
                        </div> -->
                        <div class="ownerDetail">
                            <div class="c_D">
                                <?php //print_r($post);  ?>
                                <!-- <h3>Post Detail</h3> -->
                                
                                <p><span>User Name</span> : <span><?php echo $name ; ?></span></p>
                                <p><span>Post Message</span> : <span><?php echo $message ; ?></span></p>
                                <p><span>Post Status:</span> : <span><?php echo $status ; ?></span></p>
                                <p><span>Post CreatedOn:</span> : <span><?php echo $createdOn ; ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="c_Doc c_dtl">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="post_file-tab" data-bs-toggle="tab" data-bs-target="#post_file" type="button" role="tab" aria-controls="postFile" aria-selected="true" onclick="commentListing('{{$postId}}',4,'post_file')" >File(Image/Audio/Video)</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="Details-tab" data-bs-toggle="tab" data-bs-target="#Details" type="button" role="tab" aria-controls="Details" aria-selected="true" onclick="commentListing('{{$postId}}',2,'Details')">Comment</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="post_like-tab" data-bs-toggle="tab" data-bs-target="#post_like" type="button" role="tab" aria-controls="likes" aria-selected="true" onclick="commentListing('{{$postId}}',1,'post_like')">Like</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="post_share-tab" data-bs-toggle="tab" data-bs-target="#post_share" type="button" role="tab" aria-controls="share" aria-selected="true" onclick="commentListing('{{$postId}}',3,'post_share')" >Share</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="post_file" role="tabpanel" aria-labelledby="post_file-tab">
                            Post File
                            </div>
                        <div class="tab-pane fade show " id="Details" role="tabpanel" aria-labelledby="Details-tab">
                            
                        </div>
                        <div class="tab-pane fade show " id="post_like" role="tabpanel" aria-labelledby="Details-tab">
                            Likes
                        </div>
                        <div class="tab-pane fade show " id="post_share" role="tabpanel" aria-labelledby="Details-tab">
                            Share
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
       
        var postId ='<?php echo $postId ; ?>' ;
        commentListing(postId,4,'post_file');
    });


</script>
