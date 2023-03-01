<form action="javascript:void(0);" method="post" id="editCountryForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($countryInfo->id)?$countryInfo->id:'' ; ?>">
    <div class="form modal-form">
        <div class="form-group">
            <label for="Manufacture">Title</label>
             <input type="text" name="editCTitle" id="editCTitle"  value="<?php echo isset($countryInfo->title)?$countryInfo->title:'' ; ?>" class="form-control" placeholder="Title">
             <span id="err_editCTitle" class="err" style="color:red"></span>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="javascript:void(0);"  onclick="updateCountry()" class="search-btn">Update</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>
