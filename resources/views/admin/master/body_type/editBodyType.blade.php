<form action="javascript:void(0);" method="post" id="editFuelTypeForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($bodyType->id)?$bodyType->id:'' ; ?>">
    <div class="form modal-form">
        <div class="form-group">
            <label for="Manufacture">Body Type</label>
             <input type="text" name="editFuelType" id="editFuelType"  value="<?php echo isset($bodyType->title)?$bodyType->title:'' ; ?>" class="form-control">
             <span id="err_edit_fuelType" class="err" style="color:red"></span>
        </div>
    </div>
 
    <div class="form modal-form">
        <div class="form-group">
            <label for="Manufacture">Icon</label>
             <input type="file" name="edit_bt_icon" id="edit_bt_icon"  class="form-control" >
             <span id="err_edit_bt_icon" class="err" style="color:red"></span>
        </div>
         <span style="color: red ;">[Note: Icon size = 54 x 54 ]</span>
    </div>
    <div class="mt-4">
        <a href="javascript:void(0);"  onclick="updateBodyType()" class="search-btn">Update</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>
