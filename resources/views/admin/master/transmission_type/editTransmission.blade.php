<?php 
// echo "<pre>";
// print_r($trans_type);
// exit ;
 ?>
<form action="javascript:void(0);" method="post" id="transmissionTypeForm_">
            <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($trans_type->id)?$trans_type->id:0 ; ?>">
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Transmission Type</label>
                         <input type="text" name="editTransTitle" id="editTransTitle"  class="form-control" placeholder="Transmission Type" value="<?php echo isset($trans_type->title)?$trans_type->title:0 ;   ?>">
                         <span id="err_fuelType" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="javascript:void(0);"  onclick="updateTrnasType()" class="search-btn">Update</a>
                    <a href="javascript:void(0);" id="cancelBType" onclick="cancelFuel()" class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
                </div>

            </form>