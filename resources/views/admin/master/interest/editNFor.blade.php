
<form action="javascript:void(0);" method="post" id="editFeatureForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($updatedId)?$updatedId:'' ; ?>">
    
    <div class="form modal-form">
        <div class="form-group">
            <label for="Manufacture">Title</label>
             <input type="text" name="editSTitle" id="editSTitle"  value="<?php echo isset($interestInfo->title)?$interestInfo->title:'' ; ?>" class="form-control" placeholder="Title">
             <span id="err_editSTitle" class="err" style="color:red"></span>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="javascript:void(0);"  onclick="updateNFor()" class="search-btn">Update</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>