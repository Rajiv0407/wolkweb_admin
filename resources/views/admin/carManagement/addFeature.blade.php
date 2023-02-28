<?php //print_r($featureInfo) ; ?>
<form action="javascript:void(0);" method="post" id="addFeatureForm">
    <input type="hidden" name="vehicleId" id="vehicleId" value="{{$vehicleId}}">
    <input type="hidden" name="total_feature" id="total_feature" value="{{$total_feature}}">
<div class="modal-form form m_R">
    @foreach($featureInfo as $key=>$val)
    <div class="form-group">
        <label for="audio">{{$val->title}}</label>
        <div class="b_R">
            <input type="hidden" name="featureId{{$key}}" id="featureId{{$key}}" value="{{$val->featureId}}">
            <input type="radio" id="feature_title{{$key}}" class="radio_b" name="feature_title{{$key}}" value="1" <?php echo ($val->isSelected==1)?'checked':'' ; ?> ><span>Yes</span>
            <input type="radio" id="feature_title{{$key}}" class="radio_b" name="feature_title{{$key}}" value="0" <?php echo ($val->isSelected=='0')?'checked':'' ; ?> ><span>No</span>
        </div>
    </div>
    @endforeach
                        
</div>
<div class="mt-4">
    <a href="javascript:void(0);" class="search-btn" onclick="updateVehicleFeature('{{$vehicleId}}');">Update</a>
    <a href="javascript:void(0);" class="search-btn clear-btn" onclick="cancelForm('addFeatureForm');" data-bs-dismiss="modal">Cancel</a>
</div>
</form>