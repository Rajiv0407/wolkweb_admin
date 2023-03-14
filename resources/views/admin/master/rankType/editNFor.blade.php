
<form action="javascript:void(0);" method="post" id="editFeatureForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($updatedId)?$updatedId:'' ; ?>">
    
    <div class="form modal-form">
        <div class="form-group">
            <label for="Manufacture">Title</label>
             <input type="text" name="editSTitle" id="editSTitle"  value="<?php echo isset($nFor->rank_title)?$nFor->rank_title:'' ; ?>" class="form-control" placeholder="Title">
             <span id="err_editSTitle" class="err" style="color:red"></span>
        </div>
    </div>
    
    <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Range From</label>
                         <input type="number" name="edit_rangFrom" id="edit_rangFrom"  class="form-control" value="<?php echo isset($nFor->range_from)?$nFor->range_from:'' ; ?>" placeholder="Range From">
                         <span id="err_edit_rangFrom" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Range To</label>
                         <input type="number" name="editRangeTo" id="editRangeTo"  class="form-control" value="<?php echo isset($nFor->range_to)?$nFor->range_to:'' ; ?>" placeholder="Range To">
                         <span id="err_editRangeTo" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Star Image</label>
                         <input type="file" name="editSImage" id="editSImage"  class="form-control" placeholder="Star Image">
                         <span id="err_editSImage" class="err" style="color:red"></span>
                    </div>
                </div>
    <div class="mt-4">
        <a href="javascript:void(0);"  onclick="updateNFor()" class="search-btn">Update</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>