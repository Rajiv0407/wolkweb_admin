<form action="javascript:void(0);" method="post" id="editFeatureForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($subscriber->id)?$subscriber->id:'' ; ?>">
    <input type="hidden" name="subscriberName" id="subscriberName" value="<?php echo isset($subscriber->name)?$subscriber->name:'' ; ?>">
    <input type="hidden" name="subscriberEmail" id="subscriberEmail" value="<?php echo isset($subscriber->email)?$subscriber->email:'' ; ?>">
    
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Subject</label>
                         <input type="text" name="subscriber_subject" id="subscriber_subject"  class="form-control" placeholder="Title" value="" >
                         <span id="err_subscriber_subject" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Message</label>
                        <textarea name="subscriber_message" id="subscriber_message" class="form-control" cols="30" rows="60" style="height: 188px;" placeholder="Message"></textarea>
                         <span id="err_subscriber_message" class="err" style="color:red"></span>
                    </div>
                </div>
                
    <div class="mt-4">  
        <a href="javascript:void(0);"  onclick="updateNFor()" class="search-btn">Send</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>