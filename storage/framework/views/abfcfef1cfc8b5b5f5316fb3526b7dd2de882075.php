<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
     <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Walkofweb</title>
    
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::to('/public/admin')); ?>/css/bootstrap.min.css?v=<?php echo e(time()); ?>">
   <!--  <link rel="stylesheet" href="<?php echo e(URL::to('/public/admin')); ?>/css/bootstrap-icons.css?v=<?php echo e(time()); ?>"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css?v=<?php echo e(time()); ?>">
     <script type="text/javascript" src="<?php echo e(URL::to('/public/admin')); ?>/js/jquery.min.js?v=<?php echo e(config('app.version')); ?>"></script>
     <script src="<?php echo e(URL::to('/public/admin')); ?>/js/jquery.dataTables.min.js?v=<?php echo e(time()); ?>"></script> 
    <link  href="<?php echo e(URL::to('/public/admin')); ?>/css/jquery.dataTables.min.css?v=<?php echo e(time()); ?>" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::to('/public/admin')); ?>/css/style.css?v=<?php echo e(time()); ?>">
    <link rel="icon" href="<?php echo e(URL::to('/public/admin')); ?>/images/fav.png?v=<?php echo e(time()); ?>" >
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::to('/public/admin')); ?>/css/jquery.notyfy.css?v=<?php echo e(time()); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::to('/public/admin')); ?>/css/notyfy.theme.default.css?v=<?php echo e(time()); ?>">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">

    <script src="<?php echo e(URL::to('/public/admin')); ?>/js/highcharts.js"></script>
    <script src="<?php echo e(URL::to('/public/admin')); ?>/js/data.js"></script>
    <script src="<?php echo e(URL::to('/public/admin')); ?>/js/drilldown.js"></script>
   <!--  <script src="https://code.highcharts.com/modules/exporting.js"></script> -->
    <script src="<?php echo e(URL::to('/')); ?>/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="<?php echo e(URL::to('/')); ?>/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
   
      </head>

<body>
    <script type="text/javascript">

         var baseUrl = "<?php echo e(url('/')); ?>";
    </script>
    <div class="grid-container">
         <span id="lblErrorMsg"></span>
       <!--  <section id="header" class="Header"></section>
        <section id="sidebar" class="Sidebar"></section> -->
        <section id="header" class="Header">
        <?php echo $__env->make('includes.admin.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </section>
        <section id="sidebar" class="Sidebar">
        <?php echo $__env->make('includes.admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
             </section>
             <section id="main-content" class="Main main_site_data">
                   <?php echo $__env->yieldContent('content'); ?>
             </section>

    </div>
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
  
    <!-- <script src="<?php echo e(URL::to('/public/admin')); ?>/js/bootstrap.min.js?v=<?php echo e(config('app.version')); ?>" type="text/javascript"></script> -->
    
    <script src="<?php echo e(URL::to('/public/admin')); ?>/js/bootstrap.bundle.min.js?v=<?php echo e(config('app.version')); ?>"></script>
    
    <script src="<?php echo e(URL::to('/public/admin')); ?>/js/custom.js?v=<?php echo e(config('app.version')); ?>" type="text/javascript"></script>
<!--      <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
 -->
      <script src="<?php echo e(URL::to('/public/admin')); ?>/js/jquery.notyfy.js?v=<?php echo e(config('app.version')); ?>" type="text/javascript"></script>
     
        <script src="<?php echo e(URL::to('/public/admin')); ?>/js/notyfy.init.js?v=<?php echo e(config('app.version')); ?>" type="text/javascript"></script>
     

         <script type="text/javascript">
        var primaryColor = '#6fa362',
                    dangerColor = '#b55151',
                    infoColor = '#466baf',
                    successColor = '#yellow',
                    warningColor = '#ab7a4b',
                    inverseColor = '#45484d';
            var themerPrimaryColor = primaryColor;
            
            function statusMesage(message, notifyType) {
                //alert('jk1');
                $.notyfy.closeAll();
                $('#lblErrorMsg').notyfy({
                    layout: 'bottom',
                    modal: false,
                    dismissQueue: false,
                    timeout:3000,
                    text: message,
                    type: notifyType
                });
//                var main_check = document.getElementById('input_c');
//                main_check.checked = false;
                $('input[id="input_c"]').prop('checked', false);
            
            }

           
        
   </script>
   
   <!-- change password -->
   
</body>

</html>
<?php /**PATH C:\xampp\htdocs\walkofweb_admin\resources\views/includes/admin/template.blade.php ENDPATH**/ ?>