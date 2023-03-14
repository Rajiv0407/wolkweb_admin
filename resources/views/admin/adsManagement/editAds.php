
<form action="javascript:void(0);" method="post" id="editFeatureForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($updatedId)?$updatedId:'' ; ?>">
    
    <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Sponser</label>
                        <select name="edit_sponser_" id="edit_sponser_" class="form-control" >
                            <option value="">Select</option>
                            <?php if(!empty($sponser)){ 
                                foreach($sponser as $val){ ?>
                                <option value="<?php echo $val->id ; ?>" <?php echo ($advertisement->sponser_id==$val->id)?'selected':'' ; ?> ><?php echo $val->name ; ?></option>
                            <?php } } ?>
                        </select>
                        
                         <span id="err_edit_sponser_" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Title</label>
                         <input type="text" name="edit_ads_title" id="edit_ads_title"  class="form-control" placeholder="Title" value="<?php echo isset($advertisement->title)?$advertisement->title:'' ; ?>">
                         <span id="err_edit_ads_title" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Ads Type</label>                         
                        <select name="edit_ads_type" id="edit_ads_type" class="form-control" >
                            <option value="">Select</option>
                            <option value="1" <?php echo ($advertisement->ad_type==1)?'selected':'' ; ?> >Image</option>
                            <option value="2" <?php echo ($advertisement->ad_type==2)?'selected':'' ; ?> >Video</option>
                        </select>
                         <span id="err_edit_ads_type" class="err" style="color:red"></span>
                    </div>
                </div>
    
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Start Date</label>
                         <input type="date" name="edit_startDate" id="edit_startDate"  class="form-control" placeholder="Start Date" value="<?php echo isset($advertisement->start_date)?$advertisement->start_date:'' ; ?>">
                         <span id="err_edit_startDate" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">End Date</label>
                         <input type="date" name="edit_endDate" id="edit_endDate"  class="form-control" placeholder="End Date" value="<?php echo isset($advertisement->end_date)?$advertisement->end_date:'' ; ?>">
                         <span id="err_edit_endDate" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Ads</label>
                         <input type="file" name="edit_adsFile" id="edit_adsFile"  class="form-control" placeholder="Ads File">
                         <span id="err_edit_adsFile" class="err" style="color:red"></span>
                    </div>
                </div>
                
    <div class="mt-4">
        <a href="javascript:void(0);"  onclick="updateNFor()" class="search-btn">Update</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>