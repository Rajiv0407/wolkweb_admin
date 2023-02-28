 <script type="text/javascript">

jQuery(document).ready(function ($) {
 /* menu selection .hash*/ 
   var hash = window.location;
 $('#letsgo_sidebar li a').each(function () {

var toBactive = $(this).attr('href');

if (toBactive == hash) {
    
    //$(this).parents('.sub-menu').addClass('show in');
    $(this).parents('li').addClass('active-li');  

}});


   /* end */

$('#letsgo_sidebar').find('li a').click(function(){
   
   // $('.nav-item').removeClass('active');
   // $('#rSidemenubar').find('li a.active').removeClass('active');
   //  $('ul li .nav-item').removeClass('active');
    
   // $(this).closest('ul').hasClass('sub-menu').addClass('show in');
    if($(this).closest('ul').hasClass('sub-menu')){
     $('li').removeClass('active-li'); 
     $(this).parents('li').addClass('active-li');  
        
   }
     else{
        $('li').removeClass('active-li'); 
      $('.sub-menu').removeClass('show in');
      $(this).parent('li').addClass('active-li');
    
       } });




 /* end menu selection */
  var hash = window.location.hash;
  var res = hash.split("/");
  
        if(res=='#car_management')
        {
            carManagement();
        }

        if(res!='')
        {
            $(".dashbordWrapper").css("display", "none");
        }
       
        
         if(res[0]=='#notification_for'){
            notificationFor();
        }    
        
        if(res[0]=='#country_list'){
            countryList();
        }    
        
        if(res[0]=='#state_list'){
            stateList();
        }    
        
        if(res[0]=='#city'){
            cityList(res[1]);
        }    


        if(res[0]=='#vehicle_features'){
            vehicleFeatures();
        }            

        if(res[0]=='#mailboxDetail'){
            mailBoxDetail(res[1]);
        }



        if(res[0]=='#car_detail'){
            carDetail(res[1]);
        }

        if(res[0]=='#vehicle_booking_detail'){
            vehicleBookingDetail(res[1],1);
        }
       
        if(res[0]=='#customer_detail'){
            customerDetail(res[1]);
        }
        if(res[0]=='#customer_booking_detail'){
            vehicleBookingDetail(res[1],2);
        }

        if(res[0]=='#car_booking_detail'){
            vehicleBookingDetail(res[1],3);
        }

        if(res[0]=='#contactSupport'){
            contactSupport();
        }

        if(res[0]=='#notification_detail'){
            notificationDetail(res[1]);
        }

        if(res[0]=='#index'){
            dashboard();
        }

        if(res[0]=='#termCondition'){
            termCondition();
        }

        if(res[0]=='#privacyPolicy'){
            privacyPolicy();
        }

        if(res[0]=='#help'){
            helpSupport();
        }

        if(res[0]=='#fule_type'){
            fuleTypeList();
        }

        if(res[0]=='#transmission_type'){
            transmissionTypeList();
        }

        if(res[0]=='#body_type'){
            bodyTypeList();
        }

        if(res[0]=='#body_type'){
            bodyTypeList();
        }

        if(res[0]=='#customer_management'){
            customerManagement();
        }

        if(res[0]=='#car_management'){
            carManagement();
        }


        if(res[0]=='#notification'){
            notificationList();
        }

        if(res[0]=='#mailbox'){
            mailBoxList();
        }   
        
        if(res[0]=='#car_booking'){
            carBookingManagement();
        }
        
        if(res[0]=='#rating'){
            //ratingList();
        }
   
        // if(res[1]=='detail' && res[0]=='#appointment' && res[2]!='')
        // {
        //    appointmentdetail(res[2]);
        // }
   
});

</script>

    <div class="header_logo">
    <a class="navbar-brand" href="#">
                <img src="{{URL::to('/public/admin')}}/images/lesgo_logo.png?v" class="un-clp-logo" alt="">
                 <img src="{{URL::to('/public/admin')}}/images/lesgo_logo-sml.png?v" class="clp-logo" alt="">
            </a>
            </div>

    <div class="sidebarWrapper">
         
    <ul class="height_navigation" id="letsgo_sidebar">
     
        <li><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard();"><i class="ri-dashboard-line"></i><span class="tooltip_nav">Dashboard</span></a></li>
        <li><a href="{{URL::to('/')}}/administrator/dashboard#car_management" onclick="carManagement()"><i class="ri-car-line"></i>
         <span class="tooltip_nav">
        Car Management </span> </a></li>
       <!--  <li><a href="{{URL::to('/')}}/administrator/dashboard#customer_management" onclick="customerManagement()"><i class="ri-user-settings-line"></i>
           <span class="tooltip_nav">
        Customer Management
    </span></a></li> -->

     <!--    <li><a href="{{URL::to('/')}}/administrator/dashboard#car_booking" onclick="carBookingManagement()"><i class="ri-file-4-line"></i>
<span class="tooltip_nav">
        Car Booking
    </span></a></li> -->
        <!-- <li><a href="{{URL::to('/')}}/administrator/mailbox">
            <i class="ri-mail-line"></i>
             <span class="tooltip_nav">Mailbox</span>
          </a>
      </li> -->

       <!--  <li><a href="{{URL::to('/')}}/administrator/dashboard#rating" onclick="ratingList()">Rating & Reviews</a></li> -->

        <li><a href="{{URL::to('/')}}/administrator/rating" ><i class="ri-star-smile-line"></i>
        <span class="tooltip_nav"> 
        Rating & Reviews
        </span> </a></li>

        <!-- <li><a href="{{URL::to('/')}}/administrator/dashboard#contactSupport" onclick="contactSupport()"><i class="ri-customer-service-2-line"></i>
         
    <span class="tooltip_nav">Contact Support</span></a></li> -->

      <!--   <li><a href="{{URL::to('/')}}/administrator/dashboard#notification" onclick="notificationList()"><i class="ri-notification-3-line"></i>
        <span class="too ltip_nav">
 Notification Management
        </span>
    </a></li> -->
        <li>
            <div class="cms_nav">
                <a class="" id="drop_nav"><span><i class="ri-settings-3-line"></i>
                      <span class="tooltip_nav">CMS</span>
                </span>
                    <!-- <span class="tooltip_nav">CMS</span> -->
                <span class="dropdown_tog"><i class="ri-arrow-drop-down-line"></i></span>
                </a>
                <ul class="dropdown-menu" id="drop_content">
                    <li><a href="{{URL::to('/')}}/administrator/dashboard#termCondition" onclick="termCondition()">
                     <i class="ri-arrow-right-s-line"></i>
                     <span class="tooltip_nav">
                    Terms & Conditions
                     </span>
                </a></li>
                    <li><a href="{{URL::to('/')}}/administrator/dashboard#privacyPolicy" onclick="privacyPolicy()">
                     <i class="ri-arrow-right-s-line"></i>
                     <span class="tooltip_nav">
                       Privacy Policy
                     </span>
                </a></li>
                    <li><a href="{{URL::to('/')}}/administrator/dashboard#help" onclick="helpSupport()">
                      <i class="ri-arrow-right-s-line"></i>
                      <span class="tooltip_nav">   Helps</span>
                </a></li>
                </ul>
            </div>
        </li>
        <!-- <li>
            <div class="master_nav">
                <a class="" id="master_n"><span><i class="ri-sound-module-line"></i>
                     <span class="tooltip_nav">Master</span>
                </span> <span class="dropdown_tog"><i class="ri-arrow-drop-down-line"></i></span></a>
                <ul class="dropdown-menu" id="drop_content_m">
                    <li><a href="{{URL::to('/')}}/administrator/dashboard#fule_type" onclick="fuleTypeList()">
                    <i class="ri-arrow-right-s-line"></i>
                    <span class="tooltip_nav">Fuel Type</span>
                    </a></li>
                    <li><a href="{{URL::to('/')}}/administrator/dashboard#transmission_type" onclick="transmissionTypeList()">
                    <i class="ri-arrow-right-s-line"></i>
                     <span class="tooltip_nav">Transmission Type</span>
                    </a></li>
<li><a href="{{URL::to('/')}}/administrator/dashboard#body_type" onclick="bodyTypeList()">
<i class="ri-arrow-right-s-line"></i>
<span class="tooltip_nav">Body Type</span>
</a></li>
<li><a href="{{URL::to('/')}}/administrator/dashboard#vehicle_features" onclick="vehicleFeatures()">
<i class="ri-arrow-right-s-line"></i>
<span class="tooltip_nav">Vehicle Features</span>
</a></li>
<li><a href="{{URL::to('/')}}/administrator/dashboard#country_list" onclick="countryList()">
<i class="ri-arrow-right-s-line"></i>
<span class="tooltip_nav">Country</span>
</a></li>
<li><a href="{{URL::to('/')}}/administrator/dashboard#state_list" onclick="stateList()">
<i class="ri-arrow-right-s-line"></i>
<span class="tooltip_nav">State</span>
</a></li>
<li><a href="{{URL::to('/')}}/administrator/dashboard#notification_for" onclick="notificationFor()">
<i class="ri-arrow-right-s-line"></i>
<span class="tooltip_nav">Notification For</span>
</a></li>

                                                       
                </ul>
            </div>
        </li> -->
    </ul>
</div>
<script type="text/javascript">
    $("#drop_nav").click(function() {
    $("#drop_content").delay(4000).toggleClass();
});

$("#master_n").click(function() {
    $("#drop_content_m").delay(4000).toggleClass();
});
$('.cms_nav #drop_nav').click(function(){
    $('.cms_nav #drop_nav').toggleClass('show_submenu');
});
$('.master_nav #master_n').click(function(){
    $('.master_nav #master_n').toggleClass('show_submenu');
});

</script>

