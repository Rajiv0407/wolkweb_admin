
<div class="ml_r cmT_R filterWrapper">
    <div class="re_r">

        <a href="javascript:void(0);" onclick="fetch_data('{{$currentPage}}','','{{$messageType}}')"><i class="bi bi-reply-fill"></i></a>
        <a href="{{URL::to('/')}}/administrator/mailbox" onclick="deleteDetailMessage('{{$conversationId}}')"><i class="bi bi-trash-fill"></i></a>
    </div>
    <div class="cmT_sBj border-bottom">
        <?php foreach ($message_detail as $key => $value) {  ?>
            <?php if($key==0){  ?>
                <p class="mt-3 mb-1 fs-5 d-block"><span class="fw-600">Subject :</span> <?php echo isset($value->Subject)?$value->Subject:'' ; ?> </p>
            <?php }  ?>

            <p>

                <?php  

                $mobileNumber = isset($value->mobileNumber)?$value->mobileNumber:'' ;
                $email = isset($value->email)?$value->email:'' ;
                $senderDate = isset($value->senderDate)?$value->senderDate:'' ;
                $Body = isset($value->Body)?$value->Body:'' ;
                $name = isset($value->name)?$value->name:'' ;
                echo $name ;
                if($mobileNumber!=''){
                    echo "(".$mobileNumber.")" ;
                }
                ?>
            </p>
            <?php if($email!=''){ ?> 
                <p class="fs-6 m-0" style="color: #B8B8B8"><?php echo $email ; ?></p>
            <?php  } ?>
            <?php if($senderDate!=''){ ?> 
                <p class="text-end m-0"><?php echo $senderDate ; ?></p>
            <?php } ?>
            
            <?php if($Body!=''){ ?> 
                <p class="lh-lg"><?php echo $Body ?></p>        
            <?php } ?>


        <?php } ?>
        
        
    </div>

    <div id="message_reply">
        
    </div>
    
    <form action="javascript:void(0);" method="post" class="" id="replyMessage"> 
        <input type="hidden" name="conversationId" id="conversationId" value="<?php echo $conversationId ; ?>" >
        
        <div class="mt-3">
            <textarea name="messageReply" id="messageReply" cols="5" rows="5" class="form-control"></textarea>
            <span class="err" id="err_messagereply_" style="color: red ;"></span>
        </div>
        <div class="d-flex max-w-250 mt-3">
            <a href="javascript:void(0);" onclick="messageReply()" class="search-btn">Reply</a>
            
            <a href="javascript:void(0);" onclick="fetch_data('{{$currentPage}}','','{{$messageType}}')" class="search-btn clear-btn ml-5px">Cancel</a>
        </div>
    </form>
</div>


