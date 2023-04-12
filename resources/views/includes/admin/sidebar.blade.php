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
  
        if(res!='')
        {
            $(".dashbordWrapper").css("display", "none");
        }
       
        
         if(res[0]=='#notification_for'){
            notificationFor();
        }    
        
        if(res[0]=='#customer_detail'){
            customerDetail(res[1]);
        }    

        if(res[0]=='#country_list'){
            countryList();
        }    
 
        
        if(res[0]=='#rankType'){
            rankTypeList();
        }    
        
        if(res[0]=='#interest'){
            interestList();
        }   

        if(res[0]=='#customer_management'){
            customerManagement();
        }  


        if(res[0]=='#sponser'){
            sponserList();
        }            


       
        if(res[0]=='#advertisement_detail'){
            advertisementDetail(res[1]);
        }

        if(res[0]=='#userPoint_detail'){
            userPointDetail(res[1]);
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

       
        if(res[0]=='#notification'){
            notificationList();
        }
        if(res[0]=='#post_management'){
        
            postManagement();
        }
        
        if(res[0]=='#adsManagement'){
            adsManagement();
        }

        if(res[0]=='#socialManagement'){
            
            socialManagement(); 
        }
        if(res[0]=='#usersocialpoint'){
            userPointList();   
        }  
        if(res[0]=='#subscriptions'){
            subscriptionList();   
        } 
        if(res[0]=='#post_detail'){
            postDetail(res[1]);   
        } 
});
</script>
    <div class="header_logo">
    <a class="navbar-brand" href="#">
                <img src="{{URL::to('/public/admin')}}/images/sitebar_icon/logo-new.png?{{time();}}" class="un-clp-logo" alt="">
                 <img src="{{URL::to('/public/admin')}}/images/lesgo_logo-sml.png?{{time();}}" class="clp-logo" alt="">
            </a>
            </div>
    <div class="sidebarWrapper">   
    <ul class="height_navigation" id="letsgo_sidebar">
        <li><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard();">
        <!-- <i class="ri-dashboard-line"></i> -->
        <img src="<?php echo e(URL::to('/')); ?>/public/admin/images/sitebar_icon/icon1.png" alt="">
        <span class="tooltip_nav">Dashboard</span></a></li>
     
        <li><a href="{{URL::to('/')}}/administrator/dashboard#customer_management" onclick="customerManagement()">
        <!-- <i class="ri-user-settings-line"></i> -->
        <img src="<?php echo e(URL::to('/')); ?>/public/admin/images/sitebar_icon/UsersThree.png" alt="">
           <span class="tooltip_nav">
        Customer Management
    </span></a></li>
    <li><a href="{{URL::to('/')}}/administrator/dashboard#post_management" onclick="postManagement()">
    <!-- <i class="ri-user-settings-line"></i> -->
    <img src="<?php echo e(URL::to('/')); ?>/public/admin/images/sitebar_icon/Image.png" alt="">
           <span class="tooltip_nav">
        Post Management
    </span></a></li>
    <li><a href="{{URL::to('/')}}/administrator/dashboard#adsManagement" onclick="adsManagement()">
    <!-- <i class="ri-user-settings-line"></i> -->
    <img src="<?php echo e(URL::to('/')); ?>/public/admin/images/sitebar_icon/Television.png" alt="">
           <span class="tooltip_nav">
        Ads Management
    </span></a></li>
    <!-- <li><a href="{{URL::to('/')}}/administrator/dashboard#socialManagement" onclick="socialManagement()"><i class="ri-user-settings-line"></i>
           <span class="tooltip_nav">
        Soical Management
    </span></a></li> -->
        <li><a href="{{URL::to('/')}}/administrator/dashboard#contactSupport" onclick="contactSupport()">
        <!-- <i class="ri-customer-service-2-line"></i> -->
        <img src="<?php echo e(URL::to('/')); ?>/public/admin/images/sitebar_icon/AddressBook.png" alt="">
    <span class="tooltip_nav">Contact Support</span></a></li>
        <li><a href="{{URL::to('/')}}/administrator/dashboard#notification" onclick="notificationList()">
        <!-- <i class="ri-notification-3-line"></i> -->
        <img src="<?php echo e(URL::to('/')); ?>/public/admin/images/sitebar_icon/BellSimple.png" alt="">
        <span class="too ltip_nav">
 Notification Management
        </span>
    </a></li>
    <li><a href="{{URL::to('/')}}/administrator/dashboard#subscriptions" onclick="subscriptionList()">
    <!-- <i class="ri-notification-3-line"></i> -->
    <img src="<?php echo e(URL::to('/')); ?>/public/admin/images/sitebar_icon/IdentificationBadge.png" alt="">
        <span class="too ltip_nav">
 User Subscribers
        </span>
    </a></li>
    <li>
            <div class="social_nav">  
                <a class="" id="social_drop_nav"><span>
                    <!-- <i class="ri-settings-3-line"></i> -->
                    <img src="<?php echo e(URL::to('/')); ?>/public/admin/images/sitebar_icon/At.png" alt="">
                      <span class="tooltip_nav">Social Management</span>
                </span>
                    <!-- <span class="tooltip_nav">CMS</span> -->
                <span class="dropdown_tog"><i class="ri-arrow-drop-down-line"></i></span>
                </a>
                <ul class="dropdown-menu" id="drop_content12">
                <li><a href="{{URL::to('/')}}/administrator/dashboard#socialManagement" onclick="socialManagement()"><i class="ri-arrow-right-s-line"></i>
                     <span class="tooltip_nav">
                    Point  Weightage
                     </span>
                </a></li>
                    <li><a href="{{URL::to('/')}}/administrator/dashboard#usersocialpoint" onclick="userPointList()">
                     <i class="ri-arrow-right-s-line"></i>
                     <span class="tooltip_nav">
                       User Social Point
                     </span> 
                </a></li>
                  
                </ul>     
            </div>
        </li>
        <li>
            <div class="cms_nav">
                <a class="" id="drop_nav"><span>
                    <!-- <i class="ri-settings-3-line"></i> -->
                    <img src="<?php echo e(URL::to('/')); ?>/public/admin/images/sitebar_icon/IdentificationCard.png" alt="">
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
                </ul>
            </div>
        </li>
        <li>
            <div class="master_nav">
                <a class="" id="master_n"><span>
                    <!-- <i class="ri-sound-module-line"></i> -->
                    <img src="<?php echo e(URL::to('/')); ?>/public/admin/images/sitebar_icon/Notebook.png" alt="">
                     <span class="tooltip_nav">Master</span>
                </span> <span class="dropdown_tog"><i class="ri-arrow-drop-down-line"></i></span></a>
                <ul class="dropdown-menu" id="drop_content_m"> 
                <li><a href="{{URL::to('/')}}/administrator/dashboard#country_list" onclick="countryList()">
                <i class="ri-arrow-right-s-line"></i>
                <span class="tooltip_nav">Country</span>
                </a></li>

                <li><a href="{{URL::to('/')}}/administrator/dashboard#notification_for" onclick="notificationFor()">
                <i class="ri-arrow-right-s-line"></i>
                <span class="tooltip_nav">Notification Type</span>
                </a></li>   

                <li><a href="{{URL::to('/')}}/administrator/dashboard#rankType" onclick="rankTypeList()">
                <i class="ri-arrow-right-s-line"></i>
                <span class="tooltip_nav">Rank Type</span>
                </a></li>

                <li><a href="{{URL::to('/')}}/administrator/dashboard#sponser" onclick="sponserList()">
                <i class="ri-arrow-right-s-line"></i>
                <span class="tooltip_nav">Sponser</span>
                </a></li>

                 <li><a href="{{URL::to('/')}}/administrator/dashboard#interest" onclick="interestList()">
                <i class="ri-arrow-right-s-line"></i>
                <span class="tooltip_nav">Interest</span>
                </a></li> 

                                        
                </ul>
            </div>
        </li>
    </ul>
</div>
<script type="text/javascript">
    $("#drop_nav").click(function() { 
    $("#drop_content").delay(4000).toggleClass();
});
$("#social_drop_nav").click(function() {
    $("#drop_content12").delay(4000).toggleClass();
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
$('.social_nav #social_drop_nav').click(function(){
    $('.social_nav #social_drop_nav').toggleClass('show_submenu');
});
  

</script>

