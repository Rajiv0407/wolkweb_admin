    
    function removeModelOpen(){
          // $('.modal').removeClass('in');
          //       $('.modal').attr("aria-hidden","true");
          //       $('.modal').css("display", "none");
          //       $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
    }
    
    function getUnreadCount(){
      
        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/getUnreadCount',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
           $('#tInboxUnread').text(html);

        }

        });
    }

    function notificationFor(){
      
        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/notificationFor',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

function removeError(){
    $('.err').html('');
}


function countryList(){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/countryList',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

    function stateList(){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/stateList',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

 function cityList(stateId=0){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/cityList',
        data:{'stateId':stateId},
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

        function inboxMessageDelete(){
        //inboxMsg
        var checkedNum = $('input[name="inboxMsg[]"]:checked').length;
        if (!checkedNum) {
           
            return false ;
        }

        //var result = confirm("Are you sure to delete this conversation?");
        if(!confirm("Are you sure to delete this conversation?")){
            return false ;
        }

        ajaxCsrf();
                var formData = $('#inboxMsgForm').serialize();
            $.ajax({
                type:"POST",
                url: baseUrl+'/deleteInboxMessg',
                data:formData,
                cache: 'FALSE',
                beforeSend: function () {
                ajax_before();
                },
                success: function(html){
                ajax_success() ;
                fetch_data(1);
                messageInfo();
                }

            });

    }


function messageInfo(){
        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/messageInfo',
        cache: 'FALSE',
       
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
            ajax_success() ;
            $('#messageInfo').html(html) ;
        
            }
        });

    }



function fetch_data(page,searchData='',messageType_=''){
    if(messageType_==''){
        var messageType = $('#messageType').val() ;
    }else{
        var messageType = messageType_ ;
    }
    
  $.ajax({
    url:baseUrl+"/ajax_inboxList?page="+page+"&searchData="+searchData+"&messageType="+messageType,
        success:function(data){
        $('#messageDetail_').html(data);
    }

    });
}


function carRatingReview(id){
         ajaxCsrf();
  
        $.ajax({
        type:"get",
        url:baseUrl+'/carManagement/carReviews',
        data:{"vehicleId":id},
       
        beforeSend:function()
        {
            ajax_before();
        },
        success:function(html)
        {

            ajax_success() ;
          
           $('#Rating').html(html);
        
        }
        });
    }

function approveReview(reviewId){

    ajaxCsrf();

        $.ajax({
            type:"POST",
            url:baseUrl+'/approveReview',
            data:{"reviewId":reviewId},
            dataType:'json',
            beforeSend:function()
            {
                ajax_before();
            },
            success:function(html)
            {
                ajax_success() ;
                  
                if(html.status==1){
                    $('#reviewStatus'+reviewId).removeClass("rejectStatus");
                    $('#reviewStatus'+reviewId).removeClass("pendingStatus");
                    $('#reviewStatus'+reviewId).addClass("approveStatus");
                    $('#reviewStatus'+reviewId).text('Approve') ;
                   statusMesage('Approved successfully','success');
                }else{
                   statusMesage('something went wrong','error');
                }
                           
            }
        });    
}


function rejectReview(reviewId){

    ajaxCsrf();
        $.ajax({
            type:"POST",
            url:baseUrl+'/rejectReview',
            data:{"reviewId":reviewId},
            dataType:'json',
            beforeSend:function()
            {
                ajax_before();
            },
            success:function(html)
            {
                ajax_success() ;
                if(html.status==1){

                
                $('#reviewStatus'+reviewId).removeClass("pendingStatus");
                $('#reviewStatus'+reviewId).removeClass("approveStatus");
                $('#reviewStatus'+reviewId).addClass("rejectStatus");
                    $('#reviewStatus'+reviewId).text('Rejected') ;
                   statusMesage('Rejected successfully','success');
                }else{
                   statusMesage('something went wrong','error');
                }
            
            }
        });
}

 function carRentBooking(id,type=1,divId='Rent'){
         ajaxCsrf();

        $.ajax({type:"POST",
        url:baseUrl+'/carManagement/carRentBooking',
        data:{"vehicleId":id,"type":type},
       
        beforeSend:function()
        {
            ajax_before();
        },
        success:function(html)
        {
            ajax_success() ;
            $('#'+divId).html(html);
        
        }
        });
    }

function modalHide_(id){
    $('#'+id).modal('hide'); 
    $('body').removeClass('modal-open');
    $('body').css('padding-right', '0px');
    $('.modal-backdrop').remove();    
}


function showModal(id){
   $('#'+id).modal('show');
}


function cancelForm(frormId){
  $('#'+frormId)[0].reset() ;
}

function modalHide(modalId){
    $('#'+modalId).modal('hide');
    $('.modal-backdrop').hide();    
}
function datatablePagination($k){
   $k.extend($k.fn.dataTableExt.oStdClasses, {
            "sWrapper": "dataTables_wrapper"
        });
        /* API method to get paging information */
        $k.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
        {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        }
       
/* Bootstrap style pagination control */
$k.extend($k.fn.dataTableExt.oPagination, {
    "bootstrap": {
        "fnInit": function(oSettings, nPaging, fnDraw) {
            var oLang = oSettings.oLanguage.oPaginate;
            var fnClickHandler = function(e) {
                e.preventDefault();
                if (oSettings.oApi._fnPageChange(oSettings, e.data.action)) {
                    fnDraw(oSettings);
                }
            };
            $k(nPaging).append(
                '<ul class="pagination">' +
                '<li class="prev disabled"><a href="#">&larr; ' + oLang.sFirst + '</a></li>' +
                '<li class="prev disabled"><a href="#">&larr; ' + oLang.sPrevious + '</a></li>' +
                '<li class="next disabled"><a href="#">' + oLang.sNext + ' &rarr; </a></li>' +
                '<li class="next disabled"><a href="#">' + oLang.sLast + ' &rarr; </a></li>' +
                '</ul>'
                );
            var els = $k('a', nPaging);
            $k(els[0]).bind('click.DT', {action: "first"}, fnClickHandler);
            $k(els[1]).bind('click.DT', {action: "previous"}, fnClickHandler);
            $k(els[2]).bind('click.DT', {action: "next"}, fnClickHandler);
            $k(els[3]).bind('click.DT', {action: "last"}, fnClickHandler);
        },
        "fnUpdate": function(oSettings, fnDraw) {
            var iListLength = 5;
            var oPaging = oSettings.oInstance.fnPagingInfo();
            var an = oSettings.aanFeatures.p;
            var i, j, sClass, iStart, iEnd, iHalf = Math.floor(iListLength / 2);
            if (oPaging.iTotalPages < iListLength) {
                iStart = 1;
                iEnd = oPaging.iTotalPages;
            }
            else if (oPaging.iPage <= iHalf) {
                iStart = 1;
                iEnd = iListLength;
            } else if (oPaging.iPage >= (oPaging.iTotalPages - iHalf)) {
                iStart = oPaging.iTotalPages - iListLength + 1;
                iEnd = oPaging.iTotalPages;
            } else {
                iStart = oPaging.iPage - iHalf + 1;
                iEnd = iStart + iListLength - 1;
            }
            for (i = 0, iLen = an.length; i < iLen; i++) {
                                // Remove the middle elements
                                $k('li:gt(1)', an[i]).filter(':not(.next)').remove();
                                // Add the new list items and their event handlers
                                for (j = iStart; j <= iEnd; j++) {
                                    sClass = (j == oPaging.iPage + 1) ? 'class="active"' : '';
                                    $k('<li ' + sClass + '><a href="#">' + j + '</a></li>')
                                    .insertBefore($k('li.next:first', an[i])[0])
                                    .bind('click', function(e) {
                                        e.preventDefault();
                                        oSettings._iDisplayStart = (parseInt($k('a', this).text(), 10) - 1) * oPaging.iLength;
                                        fnDraw(oSettings);
                                    });
                                }
                                // Add / remove disabled classes from the static elements
                                if (oPaging.iPage === 0) {
                                    $k('li.prev', an[i]).addClass('disabled');
                                } else {
                                    $k('li.prev', an[i]).removeClass('disabled');
                                }
                                if (oPaging.iPage === oPaging.iTotalPages - 1 || oPaging.iTotalPages === 0) {
                                    $k('li.next', an[i]).addClass('disabled');
                                } else {
                                    $k('li.next', an[i]).removeClass('disabled');
                                }
                            }
                        }
                    }
                });

                /*$dateControls= $("#baseDateControl").children("div").clone();
                $("#feedbackTable_filter").prepend($dateControls);*/
                /*
                 * TableTools Bootstrap compatibility
                 * Required TableTools 2.1+
                 */
                 if ($k.fn.DataTable.TableTools) {
                    // Set the classes that TableTools uses to something suitable for Bootstrap
                    $k.extend(true, $k.fn.DataTable.TableTools.classes, {
                        "container": "DTTT btn-group",
                        "buttons": {
                            "normal": "btn btn-primary",
                            "disabled": "disabled"
                        },
                        "collection": {
                            "container": "DTTT_dropdown dropdown-menu",
                            "buttons": {
                                "normal": "",
                                "disabled": "disabled"
                            }
                        },
                        "print": {
                            "info": "DTTT_print_info modal"
                        },
                        "select": {
                            "row": "active"
                        }
                    });
                    // Have the collection use a bootstrap compatible dropdown
                    $k.extend(true, $k.fn.DataTable.TableTools.DEFAULTS.oTags, {
                        "collection": {
                            "container": "ul",
                            "button": "li",
                            "liner": "a"
                        }
                    });
                }

}

function ajaxCsrf(){
	 $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
}

function ajax_before(){
     var over = '<div class="overlay" style="margin-left:20%;margin-top:20%;position:absolute;z-index:1;"><img id="loading" width="" src="' + baseUrl + '/public/admin/images/loader.gif"></div>';
          $(over).prependTo('.main_site_data');
}

function ajax_success(){
     $('.overlay').remove();
}




function vehicleBookingDetail(bookingId,type=1){
     
      ajaxCsrf();

        $.ajax({
        type:"POST",
        url:baseUrl+'/carManagement/bookingDetail',
        data:{"bookingId":bookingId,"type":type},
       
        beforeSend:function()
        {
            ajax_before();
        },
        success:function(html)
        {
            ajax_success() ;
           $('.main_site_data').html(html);
        
        }
        });
}

function carManagement(){

       ajaxCsrf();
  
  $.ajax({
    type: "POST",
    url: baseUrl + '/carManagement',
    cache: 'FALSE',
    beforeSend: function () {
           ajax_before();
    },
    success: function(html){
     ajax_success() ;
         $('.main_site_data').html(html);
    
            }
        });
    }
 
  function customerManagement(){
        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/customerManagement',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }


 function customerDetail(userId){
        
        ajaxCsrf();

        $.ajax({
        type: "POST",
        url: baseUrl+'/customerDetail',
        data:{'userId':userId},
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
         ajax_success() ;
         $('.main_site_data').html(html);
        }

        });
    }
 
 function carBookingManagement(){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/carBooking',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

 function carBookingDetail(){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/carBookingDetail',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }


 function mailBoxList(){
       
        ajaxCsrf();
        $.ajax({
        type: "GET",
        url: baseUrl+'/administrator/mailbox',
        data:{messageType:messageType},
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }


    
function notificationDetail(id){
  ajaxCsrf();

  $.ajax({
    type:"POST",
    url:baseUrl+'/announce_detail',
   data:{"id":id},
   
  beforeSend:function()
  {
    ajax_before();
  },
  success:function(res)
  {
  ajax_success() ;
  $('.main_site_data').html(res);

  }

  });
}
function contactSupport(){


        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/contactSupport',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    

}

 function ratingList(){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/rating',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

 function notificationList(){
        
        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/notification',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

 function creteNotification(notificationId){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/create_notification',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

     function termCondition(){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/termCondition',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

     function privacyPolicy(){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/privacyPolicy',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

     function helpSupport(){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/helpSupport',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

     function fuleTypeList(){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/fuleType',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

     function bodyTypeList(){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/bodyType',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

function vehicleFeatures(){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/vehicleFeatures',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

     function transmissionTypeList(){

        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/transmissionType',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
    }

    
    function onlyNumbers(event) {
      
       var charCode = (event.which) ? event.which : event.keyCode
   
       if (charCode > 31 && (charCode < 48 || charCode > 57))
         return false;

       return true;
     }

function dashboard(){
        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/dashboard',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
}
 function vehicleDashboard(){
      ajaxCsrf();
        $.ajax({
        type: "get",
        url: baseUrl+'/administrator/dashboard',
        cache: 'FALSE',
        beforeSend: function () {
        ajax_before();
        },
        success: function(html){
        ajax_success() ;
        $('.main_site_data').html(html);

        }

        });
 }

function updateCar(){
 
     ajaxCsrf();
            var carManufacture=$('#car_manufacture').val() ;
       var carModel = $('#car_model').val() ;
       var carSeats = $('#car_seats').val() ;
       var carDoors = $('#car_doors').val() ;
       var carFuleType = $('#car_fuleType').val() ;
       var carTransType = $('#car_transmissionType').val() ;
       var carBodyType = $('#car_bodyType').val() ;
       var carPrice = $('#car_price').val() ;
       var updatedId  = $('#updatedId').val() ;
       removeError();
       if(carManufacture==''){
         $('#err_manufacture').html('Please enter manufacturer');
       }else if(carModel==''){
        $('#err_car_model').html('Please enter model');
       }else if(carSeats==''){
        $('#err_car_seats').html('Please enter number of seats');
       }else if(carDoors==''){
        $('#err_car_doors').html('Please enter number of doors');
       }else if(carFuleType==''){
        $('#err_fuel_type').html('Please select fuel type');
       }else if(carTransType==''){
        $('#err_trans_type').html('Please select transmission type');
       }else if(carBodyType==''){
         $('#err_body_type').html('Please select vehilce body type');
       }else if(carPrice==''){
         $('#err_price').html('Please enter price');
       }else{

         var formData = $('#editCarForm').serialize() ;

         $.ajax({
            type:"POST",
            url:baseUrl+'/carManagement/updateVehicle',
            data:formData ,
            dataType:'json',
            beforeSend:function()
            {
            ajax_before();
            },
            success:function(html)
            {
              ajax_success() ;
            if(html.status==1){
                
                $('#editVehicle').modal('hide');  
                $('.modal-backdrop').hide();            
                $('#dataTable').DataTable().ajax.reload();
                
                statusMesage('updated successfully','success');
               
             }else{
                 statusMesage('something went wrong','error') ;
             }
            
            }
            });
   }
}

function carDetail(id){
   
    ajaxCsrf();

    $.ajax({type:"POST",
    url:baseUrl+'/carManagement/detail',
    data:{"id":id},
   
    beforeSend:function()
    {
        ajax_before();
    },
    success:function(html)
    {
        ajax_success() ;
        $('.main_site_data').html(html);
    
    }
    });

}


    function carBasicDetail(id){
         ajaxCsrf();

        $.ajax({type:"POST",
        url:baseUrl+'/carManagement/basicDetail',
        data:{"vehicleId":id},

        beforeSend:function()
        {
            ajax_before();
        },
        success:function(html)
        {
            ajax_success() ;
            $('#Details').html(html);
          

        }
        });
    }

           