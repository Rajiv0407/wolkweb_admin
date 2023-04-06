<form action="javascript:void(0);" method="post" id="editFeatureForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($updatedId)?$updatedId:'' ; ?>">
    <input type="hidden" name="type" id="type" value="1">
    <div class="form modal-form">
                    <div class="form-group">
                        <label for="edit_sponser_">Sponser</label>
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
                        <label for="edit_ads_title">Title</label>
                         <input type="text" name="edit_ads_title" id="edit_ads_title"  class="form-control" placeholder="Title" value="<?php echo isset($advertisement->title)?$advertisement->title:'' ; ?>">
                         <span id="err_edit_ads_title" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="edit_ads_type">Ads Type</label>                         
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
                        <label for="edit_startDate">Start Date</label>
                         <input type="date" name="edit_startDate" id="edit_startDate"  class="form-control" placeholder="Start Date" value="<?php echo isset($advertisement->start_date)?$advertisement->start_date:'' ; ?>">
                         <span id="err_edit_startDate" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="edit_endDate">End Date</label>
                         <input type="date" name="edit_endDate" id="edit_endDate"  class="form-control" placeholder="End Date" value="<?php echo isset($advertisement->end_date)?$advertisement->end_date:'' ; ?>">
                         <span id="err_edit_endDate" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="edit_adsFile">Ads</label>
                         <input type="file" name="edit_adsFile" id="edit_adsFile"  class="form-control" placeholder="Ads File">
                         <span id="err_edit_adsFile" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="introduction">Introduction</label>
                         <textarea name="introduction" id="introduction" style="height: 80px;" class="form-control" cols="30" rows="4"><?php echo isset($advertisement->introduction)?$advertisement->introduction:'' ; ?></textarea>
                         <span id="err_introduction" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="objectives">Objectives</label>
                         <textarea name="objectives" id="objectives" style="height: 80px;" class="form-control" cols="30" rows="4"><?php echo isset($advertisement->objectives)?$advertisement->objectives:'' ; ?></textarea>
                         <span id="err_objectives" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="media_mix">Media Mix</label>
                         <textarea name="media_mix" id="media_mix" style="height: 80px;" class="form-control" cols="30" rows="4"><?php echo isset($advertisement->media_mix)?$advertisement->media_mix:'' ; ?></textarea>
                         <span id="err_media_mix" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="measurement">Measurement</label>
                         <textarea name="measurement" id="measurement" style="height: 80px;" class="form-control" cols="30" rows="4"> <?php echo isset($advertisement->measurement)?$advertisement->measurement:'' ; ?></textarea>
                         <span id="err_measurement" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="conclusion">Conclusion</label>
                         <textarea name="conclusion" id="conclusion" style="height: 80px;" class="form-control" cols="30" rows="4"><?php echo isset($advertisement->conclusion)?$advertisement->conclusion:'' ; ?></textarea>
                         <span id="err_conclusion" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="target_audience">Target Audience</label>
                         <textarea name="target_audience" id="target_audience" style="height: 80px;" class="form-control" cols="30" rows="4"><?php echo isset($advertisement->target_audience)?$advertisement->target_audience:'' ; ?></textarea>
                         <span id="err_target_audience" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="media_sample">Media Sample</label>
                         <textarea name="media_sample" id="media_sample" style="height: 80px;" class="form-control" cols="30" rows="4"><?php echo isset($advertisement->media_sample)?$advertisement->media_sample:'' ; ?>    </textarea>
                         <span id="err_media_sample" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="is_accept">Is Accept</label>                         
                        <select name="is_accept" id="is_accept" class="form-control" >
                            <option value="">Select</option>
                            <option value="1" <?php echo ($advertisement->ad_type==1)?'selected':'' ; ?> >Yes</option>
                            <option value="2" <?php echo ($advertisement->ad_type==2)?'selected':'' ; ?> >No</option>
                        </select>
                         <span id="err_is_accept" class="err" style="color:red"></span>
                    </div>
                </div>
                
    <div class="mt-4">
        <a href="javascript:void(0);"  onclick="updateNFor()" class="search-btn">Update</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>