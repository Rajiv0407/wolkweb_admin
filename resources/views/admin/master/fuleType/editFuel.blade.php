


<form action="javascript:void(0);" method="post" id="editFuelTypeForm">
           <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($fuelType->id)?$fuelType->id:'' ; ?>">
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Fuel Type</label>
                         <input type="text" name="editFuelType" id="editFuelType"  value="<?php echo isset($fuelType->title)?$fuelType->title:'' ; ?>" class="form-control">
                         <span id="err_edit_fuelType" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Icon</label>
                         <input type="file" name="edit_icon_fuelType" id="edit_icon_fuelType"  class="form-control" placeholder="Fuel Type">
                         <span id="err_edit_icon_fuelType" class="err" style="color:red"></span>
                    </div>
                      <span style="color: red;">[Note: icon size = 54 x 54 ]</span>
                </div>
                <div class="mt-4">
                    <a href="javascript:void(0);"  onclick="updateFuel()" class="search-btn">Update</a>
                    <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
                </div>

            </form>