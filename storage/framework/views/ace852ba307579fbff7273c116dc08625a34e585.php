 <div class="dashbordWrapper">
                <div class="breadcrumbWrapper">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Dashboard </h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(URL::to('/')); ?>/administrator/dashboard#index">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                <div class="dashboardBox">
                    <div class="dashCard">
                        <div class="card">
                            <div class="card-header">
                                Car Listed
                            </div>
                            <div class="card-body">
                                <p><span>Today</span><br><span><?php //echo $carToday ; ?></span></p>
                                <p><span>Monthly</span><br><span><?php //echo $carMonth ; ?></span></p>
                                <p><span>Yearly</span><br><span><?php //echo $carYear ; ?></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="dashCard">
                        <div class="card">
                            <div class="card-header">
                                Car Booking
                            </div>
                            <div class="card-body">
                                <p><span>Today</span><br><span><?php //echo $bookingToday ; ?></span></p>
                                <p><span>Monthly</span><br><span><?php //echo $bookingMonth ; ?></span></p>
                                <p><span>Yearly</span><br><span><?php //echo $bookingYear ; ?></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="dashCard">
                        <div class="card">
                            <div class="card-header">
                                Customer Registration
                            </div>
                            <div class="card-body">
                                <p><span>Today</span><br><span><?php //echo $userToday ; ?></span></p>
                                <p><span>Monthly</span><br><span><?php //echo $userMonth ; ?></span></p>
                                <p><span>Yearly</span><br><span><?php //echo $userYear ; ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dashGraph">
                    <h3>Booking Sales History</h3>
                    <!-- <img src="<?php echo e(URL::to('/public/admin')); ?>/images/topbar.png" alt=""> -->
                    <div id="salesYearly"></div>
                </div>
                <div class="dashboardBox">
                    <div class="dashCard">
                        <div class="card">
                            <div class="card-header">
                                Today
                            </div>
                            <div class="card-body">
                                <p><span>Total Booking</span><br><span><?php //echo $bookingToday ; ?></span></p>
                                <p><span>Amount</span><br><span><?php //echo $bookingTodayAmt ; ?></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="dashCard">
                        <div class="card">
                            <div class="card-header">
                                Weekly
                            </div>
                            <div class="card-body">
                                <p><span>Total Booking</span><br><span><?php //echo $bookingWeekly ; ?></span></p>
                                <p><span>Amount</span><br><span><?php //echo $bookingWeeklyAmt ; ?></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="dashCard">
                        <div class="card">
                            <div class="card-header">
                                Monthly
                            </div>
                            <div class="card-body">
                                <p><span>Today</span><br><span><?php //echo $bookingMonth ; ?></span></p>
                                <p><span>Amount</span><br><span><?php //echo $bookingMonthAmt ; ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="dashGraph">
                    <h3>Booking Sales History</h3>
                    <img src="<?php echo e(URL::to('/public/admin')); ?>/images/topbar.png" alt="">
                </div> -->
            </div>

<script type="text/javascript">
    
    $(document).ready(function(){
       
        salesYearlyChart();
    });

    function salesYearlyChart(){
         ajaxCsrf();
  
        $.ajax({
        type:"post",
        url:baseUrl+'/bookingYearlyChart',
        dataType:'json',
        beforeSend:function()
        {
            ajax_before();
        },
        success:function(html)
        {
            ajax_success() ;
            var yearly = html.yearly ;
            var drilldownData = html.drilldownData ;
            salesYearly(yearly,drilldownData);        
        }
        });
    }


    function salesYearly(yearly,drilldownData){

        // Create the chart


  var chart = new   Highcharts.chart('salesYearly',
   {
        chart: {
            type: 'column'
        },
         title: {
        text: 'Booking Sales History'
    },
    subtitle: {
        text: ''
    }, credits: {
        enabled: false
      },exporting: { enabled: false },
        xAxis: {
            type: 'category'
        },yAxis: {
        title: {
          text: ''
        }

      },
        series: [{
            data: yearly,
            name:'Booking Sales Yearly'
        }],
        drilldown: {
            series: drilldownData
        }
    });
      
   /*   chart.series[1].name="Renamed";
chart.redraw();*/

    }
</script><?php /**PATH D:\xampp\htdocs\walkofwebapi\resources\views/admin/admin_dashboard.blade.php ENDPATH**/ ?>