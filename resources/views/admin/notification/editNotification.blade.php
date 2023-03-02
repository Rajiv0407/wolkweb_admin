

<form action="javascript:void(0);" method="post" id="editNotifyForm">         
<div class="modal-form form">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($updatedId)?$updatedId:'' ; ?>">
    <div class="form-group">
        <label for="">Title</label>
        <input type="text" class="form-control" name="notify_title" id="notify_title" placeholder="Enter Title" value="<?php echo isset($announceInfo->title)?$announceInfo->title:'' ; ?>">
        <span id="err_notify_title" class="err" style="color:red"></span>
    </div>

    <div class="form-group">
        <label for="">Device For <?php echo $announceInfo->deviceType ; ?></label>       
        <select class="form-control" name="deviceType" id="deviceType">
           <option value="android" <?php echo ($announceInfo->deviceType=='android')?'select':'' ; ?>>Android</option><option value="ios" <?php echo ($announceInfo->deviceType=="ios")?'selected':'' ; ?>>IOS</option><option value="both" <?php echo ($announceInfo->deviceType=="both")?'selected':'' ; ?>>Both</option>
        </select>
        <span id="err_deviceType" class="err" style="color:red"></span>
    </div>


    <div class="form-group">
        <label for="">Notification Type</label>
       
        <select class="form-control" name="nType" id="nType">
            <option value="">Select</option>
             <?php if(!empty($nType)){ ?> 
                <?php foreach ($nType as $key => $val): ?>
                      <option value="<?php echo $val->id ; ?>" <?php echo ($announceInfo->type==$val->id)?'selected':'' ; ?>><?php echo $val->title ; ?></option>
                <?php endforeach ?>
             
            <?php } ?>
        </select>
        <span id="err_nType" class="err" style="color:red"></span>
    </div>
    <?php /*  
    <div class="form-group">
        <label for="">Notification For</label>
        
        <select class="form-control" name="nFor" id="nFor">
            <option value="">Select</option>
            <?php if(!empty($nFor)){ ?> 
                <?php foreach ($nFor as $key => $value): ?>
                      <option value="<?php echo $value->id ; ?>" <?php echo ($announceInfo->nFor==$value->id)?'selected':'' ; ?>><?php echo $value->title ; ?></option>
                <?php endforeach ?>
             
            <?php } ?>
        </select>
        <span id="err_nFor" class="err" style="color:red"></span>
    </div>
    
    */ ?>

    <div class="form-group">
        <label for="">Description</label>
       
      
        <textarea class="form-control" name="nDescription" id="nDescription" rows="5" cols="15"><?php echo isset($announceInfo->content)?$announceInfo->content:'' ; ?></textarea> 
        <span id="err_nDescription" class="err" style="color:red"></span>
    </div>
      </div>
                <div class="mt-4">
                    <a href="javascript:void(0);" onclick="updateNotification();" class="search-btn">Submit</a>
                    <a href="javascript:void(0);" class="search-btn clear-btn" data-bs-dismiss="modal" onclick="cancelForm('addNotifyForm');">Cancel</a>
                </div>
            </form>