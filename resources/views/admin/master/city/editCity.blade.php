
<?php // print_r($cityInfo); exit ; ?>
<form action="javascript:void(0);" method="post" id="editFeatureForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($cityInfo->id)?$cityInfo->id:'' ; ?>">
    <input type="hidden" name="editCountryId" id="editCountryId" value="<?php echo isset($cityInfo->countryId)?$cityInfo->countryId:'' ; ?>">
    <input type="hidden" name="editStateId" id="editStateId" value="<?php echo isset($cityInfo->stateId)?$cityInfo->stateId:'' ; ?>">
    <div class="form modal-form">
        <div class="form-group">
            <label for="Manufacture">Title</label>
             <input type="text" name="editCTitle" id="editCTitle"  value="<?php echo isset($cityInfo->title)?$cityInfo->title:'' ; ?>" class="form-control" placeholder="Title">
             <span id="err_editCTitle" class="err" style="color:red"></span>
        </div>
    </div>

    <div class="mt-4 d-flex max-w-250">
        <a href="javascript:void(0);"  onclick="updateCity()" class="search-btn">Update</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn ml-5px" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>
