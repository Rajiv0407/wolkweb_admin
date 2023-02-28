<form action="javascript:void(0);" method="post" id="editFeatureForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($featureInfo->id)?$featureInfo->id:'' ; ?>">
    <div class="form modal-form">
        <div class="form-group">
            <label for="Manufacture">Title</label>
             <input type="text" name="editFTitle" id="editFTitle"  value="<?php echo isset($featureInfo->title)?$featureInfo->title:'' ; ?>" class="form-control" placeholder="Title">
             <span id="err_editFTitle" class="err" style="color:red"></span>
        </div>
    </div>
    <div class="form modal-form">
        <div class="form-group">
            <label for="Manufacture">Icon</label>
             <input type="file" name="editIcon" id="editIcon"  class="form-control">
             <span id="err_editIcon" class="err" style="color:red"></span>
        </div>
        <span style="color: red ;">[Note: Icon size = 54 x 54 ]</span> 
    </div>
    <div class="mt-4">
        <a href="javascript:void(0);"  onclick="updateFeature()" class="search-btn">Update</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>
