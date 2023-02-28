


<div class="d-flex align-items-center justify-content-between">
    <div class="re_r d-flex">
        <a href="javascript:void(0);" onclick="fetch_data(1);clearSearchForm();"><i class="bi bi-arrow-clockwise"></i> <span>Refresh</span></a> 
        <a href="javascript:void(0);" class="ml-5px" style="display:none;"  id="inboxId" 
        onclick="inboxMessageDelete()"><i class="bi bi-trash"></i> <span>Delete</span></a>

    </div>
    <div class="re_r">
        @include('admin.mailbox.pagination', ['paginator' => $inbox_list])           
    </div>

</div>



<div class="mt-4 ml_tbl" >
   <?php if($inbox_list->total() > 0){ ?> 
    <form action="javascript:void(0);" method="post" id="inboxMsgForm">
        <input type="hidden" name="messageType" id="messageType" value="{{$messageType}}">
        <?php foreach($inbox_list as $key => $value): ?>

  
            <div class="d-flex align-items-center justify-content-between in_Mr">
                <div class="in_R">
                    <input type="checkbox" class="del_msg" id="inboxMsg{{$value->mailId}}" name="inboxMsg[]" value="{{$value->mailId}}">
                    <a href="javascript:void(0);" onclick="mailBoxDetail('{{$value->MailConversationId}}','{{$inbox_list->currentPage()}}','{{$messageType}}','{{$value->readbyAdmin}}','{{$value->isTrash}}')">
                        <span><?php echo isset($value->Subject)?$value->Subject:'' ; ?></span>
                    </a>
                    <a href="javascript:void(0);" onclick="mailBoxDetail('{{$value->MailConversationId}}','{{$inbox_list->currentPage()}}','{{$messageType}}','{{$value->readbyAdmin}}','{{$value->isTrash}}')">
                        <p class="m-0"><?php echo isset($value->lastMessage)?$value->lastMessage:'' ; ?></p>
                    </a>

                </div>
                <a href="javascript:void(0);" onclick="mailBoxDetail('{{$value->MailConversationId}}','{{$inbox_list->currentPage()}}','{{$messageType}}','{{$value->readbyAdmin}}','{{$value->isTrash}}')">
                    <div>

                        <span><?php echo isset($value->senderDate)?$value->senderDate:'' ; ?></span>

                    </div>
                </a>
            </div>

        <?php endforeach ?>
    </form>
<?php } else { ?> 

   <div> Not found Data</div>
<?php } ?>
</div>

<!--    {!! $inbox_list->render() !!}    -->    

<script type="text/javascript">
 $('.del_msg').click(function(){

    var checkedNum = $('input[name="inboxMsg[]"]:checked').length;
    if (!checkedNum) {

     $('#inboxId').css('display','none');

 }else{
   $('#inboxId').css('display','block');

}

});
</script>