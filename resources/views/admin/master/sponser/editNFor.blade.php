
<form action="javascript:void(0);" method="post" id="editFeatureForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($updatedId)?$updatedId:'' ; ?>">
    
    <div class="form modal-form">
        <div class="form-group">
            <label for="Manufacture">Name</label>
             <input type="text" name="editSTitle" id="editSTitle"  value="<?php echo isset($sponserInfo->name)?$sponserInfo->name:'' ; ?>" class="form-control" placeholder="Title">
             <span id="err_editSTitle" class="err" style="color:red"></span>
        </div>
    </div>
    
    <div class="form modal-form">
                    <div class="form-group">
                        <label for="Email">Email</label>
                         <input type="text" name="editEmail" id="editEmail"  class="form-control" value="<?php echo isset($sponserInfo->email)?$sponserInfo->email:'' ; ?>" placeholder="Range From">
                         <span id="err_editEmail" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Description</label>
                         <textarea name="editDescription" id="editDescription"  rows="4" cols="50" class="form-control"  placeholder="Description"><?php echo isset($sponserInfo->description)?$sponserInfo->description:'' ; ?></textarea>
                         <span id="err_editDescription" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Icon</label>
                         <input type="file" name="editSImage" id="editSImage"  class="form-control" placeholder="Icon">
                         <span id="err_editSImage" class="err" style="color:red"></span>
                    </div>
                </div>
    <div class="mt-4">
        <a href="javascript:void(0);"  onclick="updateNFor()" class="search-btn">Update</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>