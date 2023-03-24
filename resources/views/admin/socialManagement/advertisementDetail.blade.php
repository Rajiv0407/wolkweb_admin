
<div class="carManagement__wrapper">
                <div class="breadcrumbWrapper">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Test</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#adsManagement" onclick="adsManagement()">Advertisement </a></li>
                            <li class="breadcrumb-item active" aria-current="page">Advertisement Detail</li>
                        </ol>
                    </nav>
                </div>

         <!-- sponser_id	
         title	
         url	
         ad_type	
         image	
         status	
         start_date	
         end_date	
         	
         	
         	
         	
         	
         	
         	
         isAccept -->
   
                <div class="dashCard">
                                <div class="card">
                                    <div class="card-header">
                                        <!-- <div>Basic Details</div> -->
                                        <div class="d-inline-block" style="float:right;"><a href="javascript:void(0);"  class="border-btn" data-bs-toggle="modal" data-bs-target="#editDetailVehicle"><i class="bi bi-pencil-square"></i> Edit</a></div>
                                    </div>
                    <div >
                        <p><span><b>Sponser :</b> </span><span>Test</span></p>
                        <p><span><b>Title :</b> </span><span>Test</span></p>    
                        <p><span><b>Url :</b> </span><span>Test</span></p>  
                        <p><span><b>Type :</b> </span><span>Test</span></p>  
                        <p><span><b>Ads  :</b> </span><span>Test</span></p>                   
                        <p><span><b>Start Date :</b> </span><span>Test</span></p> 
                        <p><span><b>End Date :</b> </span><span>Test</span></p> 
                        <p><span><b>Introduction:</b> </span><div><?php echo isset($advertisement->introduction)?$advertisement->introduction:'' ; ?></div></p> 
                        <p><span><b>Objectives:</b> </span><div><?php echo isset($advertisement->objectives)?$advertisement->objectives:'' ; ?></div></p> 
                        <p><span><b>Media Mix:</b> </span><div><?php echo isset($advertisement->media_mix)?$advertisement->media_mix:'' ; ?></div></p> 
                        <p><span><b>Measurement:</b> </span><div><?php echo isset($advertisement->measurement)?$advertisement->measurement:'' ; ?></div></p> 
                        <p><span><b>Conclusion:</b> </span><div><?php echo isset($advertisement->conclusion)?$advertisement->conclusion:'' ; ?></div></p> 
                        <p><span><b>Target Audience: </b></span><div><?php echo isset($advertisement->target_audience)?$advertisement->target_audience:'' ; ?></div></p> 
                        <p><span><b>Media Sample:</b> </span><div><?php echo isset($advertisement->media_sample)?$advertisement->media_sample:'' ; ?></div></p> 
                        <p><span><b>Is Accept:</b> </span><span>Yes</span></p> 
                    
                     
                    </div>  

                    
</div>


</div>

<!-- Edit basic Detail -->
                <div class="modal fade right_side" id="editDetailVehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout edit_Car_mng">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Advertisement Details</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" id="editBasicDetail">
                
<form action="javascript:void(0);" method="post" id="editFeatureForm">
    <input type="hidden" name="updatedId" id="updatedId" value="<?php echo isset($updatedId)?$updatedId:'' ; ?>">
    <input type="hidden" name="type" id="type" value="1">
    <div class="form modal-form">
                    <div class="form-group">
                        <label for="edit_sponser_">Sponser</label>
                        <select name="edit_sponser_" id="edit_sponser_" class="form-control" >
                            <option value="">Select</option>
                            <?php if(!empty($sponser)){ 
                                foreach($sponser as $val){ ?>
                                <option value="<?php echo $val->id ; ?>" <?php echo ($advertisement->sponser_id==$val->id)?'selected':'' ; ?> ><?php echo $val->name ; ?></option>
                            <?php } } ?>
                        </select>
                        
                         <span id="err_edit_sponser_" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="edit_ads_title">Title</label>
                         <input type="text" name="edit_ads_title" id="edit_ads_title"  class="form-control" placeholder="Title" value="<?php echo isset($advertisement->title)?$advertisement->title:'' ; ?>">
                         <span id="err_edit_ads_title" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="edit_ads_type">Ads Type</label>                         
                        <select name="edit_ads_type" id="edit_ads_type" class="form-control" >
                            <option value="">Select</option>
                            <option value="1" <?php echo ($advertisement->ad_type==1)?'selected':'' ; ?> >Image</option>
                            <option value="2" <?php echo ($advertisement->ad_type==2)?'selected':'' ; ?> >Video</option>
                        </select>
                         <span id="err_edit_ads_type" class="err" style="color:red"></span>
                    </div>
                </div>
    
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="edit_startDate">Start Date</label>
                         <input type="date" name="edit_startDate" id="edit_startDate"  class="form-control" placeholder="Start Date" value="<?php echo isset($advertisement->start_date)?$advertisement->start_date:'' ; ?>">
                         <span id="err_edit_startDate" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="edit_endDate">End Date</label>
                         <input type="date" name="edit_endDate" id="edit_endDate"  class="form-control" placeholder="End Date" value="<?php echo isset($advertisement->end_date)?$advertisement->end_date:'' ; ?>">
                         <span id="err_edit_endDate" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="edit_adsFile">Ads</label>
                         <input type="file" name="edit_adsFile" id="edit_adsFile"  class="form-control" placeholder="Ads File">
                         <span id="err_edit_adsFile" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="introduction">Introduction</label>
                         <textarea name="introduction" id="introduction" style="height: 80px;" class="form-control" cols="30" rows="4"><?php echo isset($advertisement->introduction)?$advertisement->introduction:'' ; ?></textarea>
                         <span id="err_introduction" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="objectives">Objectives</label>
                         <textarea name="objectives" id="objectives" style="height: 80px;" class="form-control" cols="30" rows="4"><?php echo isset($advertisement->objectives)?$advertisement->objectives:'' ; ?></textarea>
                         <span id="err_objectives" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="media_mix">Media Mix</label>
                         <textarea name="media_mix" id="media_mix" style="height: 80px;" class="form-control" cols="30" rows="4"><?php echo isset($advertisement->media_mix)?$advertisement->media_mix:'' ; ?></textarea>
                         <span id="err_media_mix" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="measurement">Measurement</label>
                         <textarea name="measurement" id="measurement" style="height: 80px;" class="form-control" cols="30" rows="4"> <?php echo isset($advertisement->measurement)?$advertisement->measurement:'' ; ?></textarea>
                         <span id="err_measurement" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="conclusion">Conclusion</label>
                         <textarea name="conclusion" id="conclusion" style="height: 80px;" class="form-control" cols="30" rows="4"><?php echo isset($advertisement->conclusion)?$advertisement->conclusion:'' ; ?></textarea>
                         <span id="err_conclusion" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="target_audience">Target Audience</label>
                         <textarea name="target_audience" id="target_audience" style="height: 80px;" class="form-control" cols="30" rows="4"><?php echo isset($advertisement->target_audience)?$advertisement->target_audience:'' ; ?></textarea>
                         <span id="err_target_audience" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group" >
                        <label for="media_sample">Media Sample</label>
                         <textarea name="media_sample" id="media_sample" style="height: 80px;" class="form-control" cols="30" rows="4"><?php echo isset($advertisement->media_sample)?$advertisement->media_sample:'' ; ?>    </textarea>
                         <span id="err_media_sample" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="is_accept">Is Accept</label>                         
                        <select name="is_accept" id="is_accept" class="form-control" >
                            <option value="">Select</option>
                            <option value="1" <?php echo ($advertisement->ad_type==1)?'selected':'' ; ?> >Yes</option>
                            <option value="2" <?php echo ($advertisement->ad_type==2)?'selected':'' ; ?> >No</option>
                        </select>
                         <span id="err_is_accept" class="err" style="color:red"></span>
                    </div>
                </div>
                
    <div class="mt-4">
        <a href="javascript:void(0);"  onclick="updateNFor()" class="search-btn">Update</a>
        <a href="javascript:void(0);"  class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
    </div>

</form>
                
              
         
         
        
         
         
         
            </div>
        </div>
    </div>
</div>
<script>
    function updateNFor(){
    
    var sponser=$('#edit_sponser_').val();
    var adsTitle=$('#edit_ads_title').val();
    var adsType=$('#edit_ads_type').val();
    var startDate=$('#edit_startDate').val();
    var endDate=$('#edit_endDate').val();
    var adsFile =$('#edit_adsFile').val();

    var introduction =$('#introduction').val();
    var objectives =$('#objectives').val();
    var media_mix =$('#media_mix').val();
    var measurement =$('#measurement').val();
    var conclusion =$('#conclusion').val();
    var target_audience =$('#target_audience').val();
    var media_sample =$('#media_sample').val();
    var is_accept =$('#is_accept').val();

    ajaxCsrf();
    $('.err').html('');
    
    if(sponser==''){
     $('#err_edit_sponser_').html('Please select sponser.');
    }else if(adsTitle==''){
      $('#err_edit_ads_title').html('Please enter ads title.');
    }else if(adsType==''){
      $('#err_edit_ads_type').html('Please select ads type.');
    }else if(startDate==''){
      $('#err_edit_startDate').html('Please select start date.');
    }else if(endDate==''){
      $('#err_edit_endDate').html('Please select end date.');
    }else if(endDate < startDate){
      $('#err_edit_endDate').html('Please select valid end date.');
    }else if(introduction==''){
      $('#err_introduction').html('Please enter introduction.');
    }else if(objectives==''){
      $('#err_objectives').html('Please enter objectives.');
    }else if(media_mix==''){
      $('#err_media_mix').html('Please enter media mix.');
    }else if(measurement==''){
      $('#err_measurement').html('Please enter measurement.');
    }else if(conclusion==''){
      $('#err_conclusion').html('Please enter conclusion.');
    }else if(target_audience==''){
      $('#err_target_audience').html('Please enter target_audience.');
    }else if(media_sample==''){
      $('#err_media_sample').html('Please enter media_sample.');
    }else if(is_accept==''){
      $('#err_is_accept').html('Please enter is_accept.');
    } else {
    
    
    $('.err').html('');
    var formData=new FormData($('#editFeatureForm')[0]);
    
    $.ajax({
        type: "POST",
        url: baseUrl +'/updateAds',
        data:formData ,
        dataType:'json',
        cache: 'FALSE',
            contentType:false,
            processData:false,
        beforeSend: function () {
               ajax_before();
        },
        success: function(html){
         ajax_success() ;
         if(html.status==1){
    
             modalHide_('edit_body'); 
            // $('.modal-backdrop').hide();   
            $('#dataTable').DataTable().ajax.reload();
            statusMesage('Update successfully','success');
            // $('#edit_fuel').modal('hide');  
                       
         }else{
             statusMesage('Something went wrong','error');
         }
          
        
                }
        });      
    
    
    
    
    }
    
    
    }
</script>