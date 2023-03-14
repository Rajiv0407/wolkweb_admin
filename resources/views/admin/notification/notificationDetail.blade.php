<?php  

  $nId = isset($announceInfo->id)?$announceInfo->id:'' ;
  $title = isset($announceInfo->title)?$announceInfo->title:'' ;
  $type = isset($announceInfo->type)?$announceInfo->type:'' ;
  $nFor = isset($announceInfo->nFor)?$announceInfo->nFor:'' ;
  $content = isset($announceInfo->content)?$announceInfo->content:'' ;
  $deviceType = isset($announceInfo->deviceType)?$announceInfo->deviceType:'' ;


?>
            <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Notifications Detail</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#notification" onclick="notificationList()">Notification</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Notifications Detail</li>
                        </ol>
                    </nav>
                </div>
                
                <form action="javascript:void(0)" class="">
                    <div class="form filterWrapper">
                        <div class="col-sm-12 p-0">
                            <div class="row">
                            
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="cms_type">Device Type</label>
                        <select name="deviceType" id="deviceType" class="form-control">
                            <option value="">-Select-</option>
                            <option value="android" <?php echo ($deviceType=='android')?'selected':'' ; ?>>Android</option>
                            <option value="ios" <?php echo ($deviceType=='ios')?'selected':'' ; ?>>IOS</option>
                            <option value="both" <?php echo ($deviceType=='both')?'selected':'' ; ?>>Both</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="cms_type">Notification Type</label>
                        <select name="" id="cms_type" class="form-control">
                            <option value="">-Select-</option>
                        <?php if(!empty($nType)): ?>
                           <?php foreach ($nType as $key => $val): ?>
                                 <option value="<?php echo $val->id ; ?>" <?php echo ($type==$val->id)?'selected':'' ; ?>><?php echo $val->title ; ?></option>
                           <?php endforeach ?>
                       <?php endif ?>
                        </select>
                    </div>
                </div>
                            </div>
                        </div>
<div class="col-sm-12 p-0">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label for="cms_type">Title</label>
                <input type="text" class="form-control" name="cms_type" id="cms_type" placeholder="Enter Title" value="<?php echo $title ; ?>">
                <?php /*
                <select name="" id="cms_type" class="form-control">
                    <option value="">-Select-</option>
                    <?php if(!empty($nForList)): ?>
                   <?php foreach ($nForList as $key => $value): ?>
                       <option value="<?php echo $value->id ; ?>" <?php echo ($nFor==$value->id)?'selected':'' ; ?>><?php echo $value->title ; ?></option>
                   <?php endforeach ?>
               <?php endif  ?>
                </select>  */ ?>
            </div>
        </div>
    </div>
</div>
                        <div class="col-sm-12 p-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="nDesc">Description</label>
                                        <textarea name="nDesc" class="textarea_control w-100 d-block p-2" placeholder="Enter Restaurant Name" id="nDesc" cols="30" rows="4"><?php echo $content ; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flare_btn__group d-flex max-w-250">
                            <a href="javascript:void(0);" class="search-btn">Send</a>
                            <a href="{{URL::to('/')}}/administrator/dashboard#notification" onclick="notificationList()" class="search-btn clear-btn ml-5px">Clear</a>
                        </div>
                    </div>
                </form>
        



