<?php //echo "<pre>" ; print_r($vehicleImg); ?>
<!-- onclick="editFeature('{{$vehicleId}}')" -->
<div class="c_P">
    <div class="edit__btn mb-3 text-end">
<a href="javascript:void(0);" class="border-btn" data-bs-toggle="modal" data-bs-target="#uploadvehicleImage" class="border-btn" ><i class="bi bi-upload"></i> Upload Images</a>
    
    </div>

    <?php if(!empty($vehicleImg)){ ?>
            <div class="image__wrapper">
      @foreach($vehicleImg as $key=>$val)

        <div class="image__box">
            <div class="checkbox__r">
                <label class="checkbox">
                    <input type="radio" id="featuredImg"  name="featuredImg" data-imgUrl="{{$val->image}}" onclick="addFeaturedImg('{{$val->id}}','{{$val->vehicleId}}','{{$val->image}}')"  <?php echo ($val->isFeatured==1)?'checked':'' ; ?>/>
                    <span></span>
                </label>
            </div>
            <div class="image_cross">
                <a href="javascript:void(0);" onclick="removeVehicleImg('{{$val->id}}','{{$val->vehicleId}}','{{$val->isFeatured}}')"><i class="bi bi-x"></i></a>
            </div>
            <div class="img__rr">
                <img src="{{$val->image}}" alt="">
            </div>
        </div>
    @endforeach
    </div>
<?php } else { ?> 

    <div class="no-rating">
                            <img src="{{URL::to('/')}}/public/admin/images/no_data.png" alt="">
                            <p>No Data Found </p>
                        </div>
<?php } ?>

</div>

