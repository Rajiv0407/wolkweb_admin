<div class="dash_wrap_inner">
     <div class="row">
         <div class="col-sm-10">
             <div class="row">
                 <div class="col-sm-12">
                     <!-- <div class="drp-list">
                         <div class="dropdown">
                             <button class="btn  dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                 Today
                             </button>
                             <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="#">Moday</a></li>
                                
                             </ul>
                         </div>
                     </div> -->
                     <!-- Testing -->
                    
    <!-- <div>
        Langauge : <select onchange="changeLanguage(this.value)" >
            <option <?php echo e(session()->has('lang_code')?(session()->get('lang_code')=='en'?'selected':''):''); ?> value="en">English</option>
            <option <?php echo e(session()->has('lang_code')?(session()->get('lang_code')=='fr'?'selected':''):''); ?> value="fr">French</option>
            <option <?php echo e(session()->has('lang_code')?(session()->get('lang_code')=='es'?'selected':''):''); ?> value="es">Spanish</option>
        </select>
    </div> -->

    <!-- <h2><?php echo e(__("messages.title")); ?></h2> -->

                     <!-- End -->
                     <ul class="list_bx">
                         <li>
                             <div class="card_bx">
                                 <h3>Downloads</h3>
                                 <div class="cont-bx">
                                     <h4><?php  echo isset($total_app_download)?$total_app_download:0 ; ?></h4>
                                     <!-- <p>+11.01% <img src="<?php //echo e(URL::to('/')); ?>/public/admin/images/ArrowRise.svg" alt=""></p> -->
                                 </div>

                             </div>
                         </li>
                         <li>
                             <div class="card_bx">
                                 <h3>Active Users</h3>
                                 <div class="cont-bx">
                                 <h4><?php  echo isset($active_user)?$active_user:0 ; ?></h4>
                                     <!-- <p>+9.15% <img src="<?php //echo e(URL::to('/')); ?>/public/admin/images/ArrowRise.svg" alt=""></p> -->
                                 </div>

                             </div>
                         </li>
                         <li>
                             <div class="card_bx">
                                 <h3>New Users</h3>
                                 <div class="cont-bx">
                                 <h4><?php  echo isset($new_user)?$new_user:0 ; ?></h4>
                                     <!-- <p>-0.56% <img src="<?php //echo e(URL::to('/')); ?>/public/admin/images/ArrowFall.svg" alt=""></p> -->
                                 </div>

                             </div>
                         </li>
                         <li>
                             <div class="card_bx">
                                 <h3>Deactivated Users</h3>
                                 <div class="cont-bx">
                                 <h4><?php  echo isset($deactive_user)?$deactive_user:0 ; ?></h4>
                                     <!-- <p>-1.48% <img src="<?php //echo e(URL::to('/')); ?>/public/admin/images/ArrowFall.svg" alt=""></p> -->
                                 </div>

                             </div>
                         </li>
                     </ul>

                 </div>
                 <div class="col-sm-8">
                    <div class="grp_wrap bg_gry">
                        <div class="grp_head">
                            <h3>Monthly User Registration</h3>
                        </div>
                    <div class="img_bx" id="current_week_container">
                            
                            </div>
                    </div>
                       
                </div>
                 
                 <div class="col-sm-4">
                 <div class="grp_wrap bg_gry">
                        <div class="grp_head">
                            <h3>Top 7 Advertisers</h3>
                        </div>
                        <div class="" id="advertisementChart"></div>
                </div>
                    

                 </div>
                 <div class="col-sm-8">
                 <div class="grp_wrap bg_gry mt-5">
                        <div class="grp_head">
                            <h3>Traffic by Location</h3>
                        </div>
                         <div class="" id="traficbyLocation">                             
                         </div>
                       </div>           
                 </div>

                 <div class="col-sm-4">
                 <div class="grp_wrap bg_gry mt-5">
                        <div class="grp_head">
                            <h3>Traffic by Platform</h3>
                        </div>
                     <div class="" style="margin-right:30px;" id="trafficbyPlateform">                         
                     </div>
</div>
                 </div>

             </div>

         </div>

     </div>

     <script type="text/javascript">
    
    $(document).ready(function(){
        var trafficByPlateform='' ;
        console.log('trafficByPlateform'+trafficByPlateform);
        trafficByPlateForm_();
        currentWeekReport_();        
        trafficByLocation_(); 
        advertisementChart_();
        
    });

   
   

function currentWeekReport(data,category){
    Highcharts.chart('current_week_container', {
    chart: {
        type: 'line',
        backgroundColor: 'transparent'
    },
    
    title: {
        text: ''
    },
    subtitle: {
        text: ' '
           
    },
    xAxis: {
        categories: category
    },
    yAxis: {
        title: {
            text: ''
        }
    },credits: {
    enabled: false
},
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series:data 
});
}

function traficbyLocation(data){
    Highcharts.chart('traficbyLocation', {
    chart: {
        type: 'column',
        backgroundColor: 'transparent'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Total User: <b>{point.y:.0f}</b>'
    },credits: {
    enabled: false
},
    series: [{
        name: 'Total User',
        data: data
       
    }]
});
              
}

function trafficbyPlateform(data){
    Highcharts.chart('trafficbyPlateform', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie',
        backgroundColor: 'transparent'
    },
    title: {
        text: '',
        align: 'center'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
    },
    accessibility: {
        point: {
            valueSuffix: ''
        }
    },credits: {
    enabled: false
},
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Total User',
        colorByPoint: true,        
        data: data
    }]
});
              
}

function advertisementChart(data,category){
    Highcharts.chart('advertisementChart', {
    chart: {
        type: 'bar',
        backgroundColor: 'transparent'
       
    }, legend: {
        enabled: false
    },
    title: {
        text: '',
        align: 'center'
    },
    subtitle: {
        text: ' ' ,            
        align: 'left'
    },
    xAxis: {
        categories: category,
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: '',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' '
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    // legend: {
    //     layout: 'vertical',
    //     align: 'right',
    //     verticalAlign: 'top',
    //     x: -40,
    //     y: 80,
    //     floating: true,
    //     borderWidth: 1,
    //     backgroundColor:
    //         Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
    //     shadow: true
    // },
    credits: {
        enabled: false
    },
    series: [ {
        name: 'Total Advertisement',
        data: data
    }]
});
}

function trafficByPlateForm_(){
        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/trafficByPlateForm',
        cache: 'FALSE',
        dataType:'json',
        beforeSend: function () {
        ajax_before();
        },
        success: function(data){
        ajax_success() ;
        trafficbyPlateform(data);
        }
        });
}

function trafficByLocation_(){
        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/trafficByLocation',
        cache: 'FALSE',
        dataType:'json',
        beforeSend: function () {
        ajax_before();
        },
        success: function(data){
        ajax_success() ;
        traficbyLocation(data);
        
        }
        });
}

function advertisementChart_(){
        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/advertisementChart',
        cache: 'FALSE',
        dataType:'json',
        beforeSend: function () {
        ajax_before();
        },
        success: function(data){
        ajax_success() ;
        advertisementChart(data.point,data.category);       
        }
        });
}
function currentWeekReport_(){
        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/currentWeekReport',
        cache: 'FALSE',
        dataType:'json',
        beforeSend: function () {
        ajax_before();
        },
        success: function(data){
        ajax_success() ;
        currentWeekReport(data.point,data.category);       
        }
        });
}
function changeLanguage(lang){
        //window.location='<?php echo e(url("change-language")); ?>/'+lang;

        ajaxCsrf();
        $.ajax({
        type: "GET",
        url: '<?php echo e(url("change-language")); ?>/'+lang,
        cache: 'FALSE',
        dataType:'json',
        beforeSend: function () {
        ajax_before();
        },
        success: function(data){
        ajax_success() ;
        dashboard();
        
        }
        });
    }
</script>

 <?php /**PATH D:\xampp\htdocs\walkofwebAdmin\walkofweb_admin\resources\views/admin/admin_dashboard.blade.php ENDPATH**/ ?>