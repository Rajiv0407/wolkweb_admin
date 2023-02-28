<form action="javascript:void(0);" method="post" id="editFeatureForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($stateInfo->id)?$stateInfo->id:'' ; ?>">
    <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Country</label>
                         
                         <select name="editSCountry" id="editSCountry"  class="form-control">
                           <option value="">Select</option>
                           <?php foreach ($country as $key => $value) { ?>
                              <option value="<?php echo $value->id ; ?>" <?php echo ($value->id==$stateInfo->countryId)?'selected':'' ; ?> ><?php echo $value->title ; ?></option>
                           <?php } ?>
                          
                         </select>
                         <span id="err_editSCountry" class="err" style="color:red"></span>
                    </div>
                </div>
    <div class="form modal-form">
        <div class="form-group">
            <label for="Manufacture">Title</label>
             <input type="text" name="editSTitle" id="editSTitle"  value="<?php echo isset($stateInfo->title)?$stateInfo->title:'' ; ?>" class="form-control" placeholder="Title">
             <span id="err_editSTitle" class="err" style="color:red"></span>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="javascript:void(0);"  onclick="updateState()" class="search-btn">Update</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>
