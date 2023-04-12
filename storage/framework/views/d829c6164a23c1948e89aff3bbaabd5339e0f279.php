<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Privacy Policy</title>
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::to('/public/admin')); ?>/css/bootstrap.min.css?v=<?php echo e(time()); ?>">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css?v=<?php echo e(time()); ?>">
     <script type="text/javascript" src="<?php echo e(URL::to('/public/admin')); ?>/js/jquery.min.js?v=<?php echo e(config('app.version')); ?>"></script>
    <script src="<?php echo e(URL::to('/public/admin')); ?>/js/highcharts.js"></script>
    <script src="<?php echo e(URL::to('/public/admin')); ?>/js/data.js"></script>
    <script src="<?php echo e(URL::to('/public/admin')); ?>/js/drilldown.js"></script>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script>
         var baseUrl = "<?php echo e(url('/')); ?>";
    </script>
</head>
<body>
<div id="social_media_followers">

</div>
    <script>
        $(document).ready(function(){
            socialmediaFollowers();            
        });

        function ajax_before(){
     var over = '<div class="overlay" style="margin-left:20%;margin-top:20%;position:absolute;z-index:1;"><img id="loading" width="" src="' + baseUrl + '/public/admin/images/loader.gif"></div>';
          $(over).prependTo('.main_site_data');
}

function ajax_success(){
     $('.overlay').remove();
}

        function socialmediaFollowers(){           
           var userId='<?php echo $userId ; ?>' ;
          
        ajaxCsrf();
        $.ajax({
        type: "POST",
        url: baseUrl+'/socialMediaFollower',
        data:{'userId':userId},
        cache: 'FALSE',
        dataType:'json',
        beforeSend: function () {
        ajax_before();
        },
        success: function(data){
        ajax_success() ;        
        socialmediaFollowers_(data.category,data.data);    
        }
        });
}

function ajaxCsrf(){
	 $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
}

function socialmediaFollowers_(categoryImgs,data){
// Create the chart
// var categoryImgs = {
//              'Chrome': 'http://192.168.1.30/walkofwebAdmin/walkofweb_admin/public/social_icon/fb.png'
           
//          };
Highcharts.chart('social_media_followers', {
    chart: {
        type: 'column'
    },
    title: {
        align: '',
        text: ''
    },
    subtitle: {
        align: '',
        text: ''
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category',
        labels: {
            useHTML: true,  
            formatter: function () {
                //console.log(categoryImgs[this.value]);
                        return '<img src="'+categoryImgs[this.value]+'"/>&nbsp;</br></br>' ;
                    }
        }
    },
    yAxis: {
        title: {
            text: ''
        }

    },credits: {
    enabled: false
},
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.0f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b>'
    },

    series: [
        {
            name: 'Total Followers',
            colorByPoint: true,
            data:data
        }
    ]

});
}



        function socialmediaFollowers_1(categoryImgs,data){
            console.log(categoryImgs);
        //     var categoryImgs = {
        //     'Jan': '<img src="http://192.168.1.30/walkofwebAdmin/walkofweb_admin/public/social_icon/fb.png">&nbsp;'
           
        // };

            Highcharts.chart('social_media_followers', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },credits: {
    enabled: false
},
    subtitle: {
        text: ''
    },  legend: {
        enabled:false,
      useHTML: true,
    
      labelFormatter: function() {

      
        return '<span style="font-weight: normal;"><image src="'+this.name+'" /> </span>';
      },
    },
    xAxis: {
        categories: [
            'walkofweb',
            'tiktok',
            'facebook',
            'insta'           
        ],
        labels: {
            useHTML: true,  
            formatter: function () {
                //console.log(categoryImgs[this.value]);
                        return '<img src="'+categoryImgs[this.value]+'">&nbsp;</br>' ;
                    }
        },
        crosshair: false
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:12px"><b>{point.key}</b></span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0"><image src="{series.name}" />: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} </td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    showInLegend:false,
    series: data
});
        }
    </script>
</body>
</html><?php /**PATH D:\xampp\htdocs\walkofwebAdmin\walkofweb_admin\resources\views/web_view/followers.blade.php ENDPATH**/ ?>