@extends('includes.admin.template')
@section('content') 
<div class="carManagement__wrapper">
   <div class="breadcrumbWrapper d-flex align-items-center justify-content-between">
      <nav aria-label="breadcrumb">
         <h3 class="fs-5 m-0 fw-500">Mailbox</h3>
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);" href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard();">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mailbox</li>
         </ol>
      </nav>
   </div>
   <div class="ml_wrap filterWrapper min-hg-150">
      <div class="ml_l filterWrapper">
         <h4 class="fs-5">Mailbox</h4>
         <div id="messageInfo">
            @include('admin.mailbox.messageInfo',['totalInboxMssg' => $totalInboxMssg,'totalTrashMssg'=>$totalTrashMssg])           
         </div>
      </div>
      <div class="ml_r filterWrapper">
         <div class="ml_R_c form">
            <h4 class="m-0 fs-5">Inbox</h4>
            <form action="javascript:void(0);" method="post" id="searchForm">
                <div class="align-items-center d-flex gap-2">
               <div class="form-group">
                  <input type="text" id="searchField" class="form-control" placeholder="Search Email / Contact No.">
                  <span><i class="bi bi-search"></i></span>
               </div>
               <div class="d-flex max-w-250" style="flex: 250px;">
               <a href="javascript:void(0);" onclick="searchMessage()" class="search-btn">
               <i class="bi bi-search"></i><span>Search</span>
               </a>
               <a href="javascript:void(0);" onclick="clearSearchForm()" class="search-btn clear-btn ml-5px">
               <i class="bi bi-eraser-fill"></i><span>Clear</span>
               </a>
           </div>
               </div>
            </form>
         </div>
         <div id="messageDetail_">
            @include('admin.mailbox.inbox_listing') 
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
       $(document).on('click','.pagination a', function(e){
           e.preventDefault();
           
           var page = $(this).attr('href').split('page=')[1] ;
           fetch_data(page) ;
       });
   
   });
   
   
   
   function ajax_inboxList_back(){
       
      ajaxCsrf();
      $.ajax({
       type: "GET",
       url: baseUrl+'/administrator/ajax_inboxList',
       cache: 'FALSE',
       beforeSend: function () {
           ajax_before();
       },
       success: function(html){
           ajax_success() ;
           $('#messageDetail_').html(html);
   
       }
   
   });
   
   }
   
   function mailBoxDetail(mailConvId,currentPage,messageType,readByAdmin=0,isTrash=0){
   
   ajaxCsrf();
   
   $.ajax({
       type: "POST",
       url: baseUrl+'/mailboxDetail',
       data:{'mailConvId':mailConvId,'currentPage':currentPage,'messageType':messageType},
       cache: 'FALSE',
       beforeSend: function () {
           ajax_before();
       },
       success: function(html){
           ajax_success() ;
           
           $('#messageDetail_').html(html);
          if(readByAdmin==0 && isTrash==0){
               getUnreadCount();
          }
   
       }
   
   });
   } 
   
   
   function messageReply(convId){
   
   ajaxCsrf();
   var message = $('#messageReply').val() ;
   $('.err').text('');
   
   if(message.length==0){
       $('#err_messagereply_').text('Please enter message.');
       return false ;
   }
   var formData = $('#replyMessage').serialize() ;
   
   $.ajax({
       type: "POST",
       url: baseUrl+'/messageReply',
       data:formData,
       cache: 'FALSE',
       dataType:'json',
       beforeSend: function () {
           ajax_before();
       },
       success: function(html){
   
           ajax_success() ;
           var timeS = html.data.message_time ;
           var message = $('#messageReply').val();
           var usrName = html.data.login_usrName ;
           var contactNumber = html.data.contact_number ;
           var emailId = html.data.emailId ;
           $('#replyMessage')[0].reset();
   // 06 Apr 2021 06:25 PM
   $('#message_reply').append('<p class="m-0">'+usrName+' ('+contactNumber+')</p> <p class="fs-6 m-0" style="color: #B8B8B8">'+emailId+'</p> <p class="text-end m-0">'+timeS+'</p> <p class="lh-lg">'+message+'</p>') ;
   
   
   }
   
   });
   }
   
   function deleteDetailMessage(conversationId){
   ajaxCsrf();
   
   
   if(!confirm("Are you sure want to delete this conversation?")){
      return false ;
   }
   $.ajax({
   type: "POST",
   url: baseUrl+'/deleteDetailMessage',
   data:{convId:conversationId},
   cache: 'FALSE',
   dataType:'json',
   beforeSend: function () {
       ajax_before();
   },
   success: function(html){
       ajax_success() ;
       fetch_data(1);
       
   
   }
   });
   
   }
   
   
   
   
   function searchMessage(){
   
   var searchData = $('#searchField').val() ;
   var page = 1 ;
   
   
   fetch_data(page,searchData);
   
   
   }
   
   function clearSearchForm(){
   $('#searchForm')[0].reset();
   fetch_data(1);
   //window.location = baseUrl+'/administrator/mailbox' ;
   }
   
   window.onload = function(){
   ajax_success() ;
   }
   
   function ajax_mailboxList(messageType=0){
   ajaxCsrf();
   
   
   $.ajax({
   type: "GET",
   url: baseUrl+'/administrator/mailbox',
   data:{messageType:messageType},
   cache: 'FALSE',
   dataType:'html',
   beforeSend: function () {
   ajax_before();
   },
   success: function(html){
   ajax_success() ;
   $('#messageDetail_').html(html);
   
   
   }
   });
   
   }
   
   
   
</script>
@endsection