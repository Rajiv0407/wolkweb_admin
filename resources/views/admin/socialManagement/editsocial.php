<form action="javascript:void(0);" method="post" id="editFeatureForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($updatedId)?$updatedId:'' ; ?>">
    
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Title</label>
                         <input type="text" name="edit_social_title" id="edit_social_title"  class="form-control" placeholder="Title" value="<?php echo isset($socialmediaweightage->title)?$socialmediaweightage->title:'' ; ?>">
                         <span id="err_edit_social_title" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">WeightAge</label>
                         <input type="text" name="edit_social_weightage" id="edit_social_weightage"  class="form-control" placeholder="weightage" value="<?php echo isset($socialmediaweightage->weightage)?$socialmediaweightage->weightage:'' ; ?>">
                         <span id="err_edit_social_weightage" class="err" style="color:red"></span>
                    </div>
                </div>
                
    <div class="mt-4">  
        <a href="javascript:void(0);"  onclick="updateNFor()" class="search-btn">Update</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>