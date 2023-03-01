<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Walkofweb</title>
    
    <link rel="stylesheet" type="text/css" href="{{URL::to('/public/admin')}}/css/bootstrap.min.css?v={{ time() }}">
   <!--  <link rel="stylesheet" href="{{URL::to('/public/admin')}}/css/bootstrap-icons.css?v={{ time() }}"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css?v={{ time() }}">
     <script type="text/javascript" src="{{URL::to('/public/admin')}}/js/jquery.min.js?v={{ config('app.version') }}"></script>
     <script src="{{URL::to('/public/admin')}}/js/jquery.dataTables.min.js?v={{ time() }}"></script> 
    <link  href="{{URL::to('/public/admin')}}/css/jquery.dataTables.min.css?v={{ time() }}" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="{{URL::to('/public/admin')}}/css/style.css?v={{ time() }}">

    <link rel="stylesheet" type="text/css" href="{{URL::to('/public/admin')}}/css/jquery.notyfy.css?v={{ time() }}">
    <link rel="stylesheet" type="text/css" href="{{URL::to('/public/admin')}}/css/notyfy.theme.default.css?v={{ time() }}">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">

    <script src="{{URL::to('/public/admin')}}/js/highcharts.js"></script>
    <script src="{{URL::to('/public/admin')}}/js/data.js"></script>
    <script src="{{URL::to('/public/admin')}}/js/drilldown.js"></script>
   <!--  <script src="https://code.highcharts.com/modules/exporting.js"></script> -->
    <script src="{{URL::to('/')}}/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="{{URL::to('/')}}/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
   
      </head>

<body>
    <script type="text/javascript">

         var baseUrl = "{{ url('/') }}";
    </script>
    <div class="grid-container">
         <span id="lblErrorMsg"></span>
       <!--  <section id="header" class="Header"></section>
        <section id="sidebar" class="Sidebar"></section> -->
        <section id="header" class="Header">
        @include('includes.admin.header')
        </section>
        <section id="sidebar" class="Sidebar">
        @include('includes.admin.sidebar')
             </section>
             <section id="main-content" class="Main main_site_data">
                   @yield('content')
             </section>

    </div>
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
  
    <script src="{{URL::to('/public/admin')}}/js/bootstrap.min.js?v={{ config('app.version') }}" type="text/javascript"></script>
    
    <script src="{{URL::to('/public/admin')}}/js/bootstrap.bundle.min.js?v={{ config('app.version') }}"></script>
    
    <script src="{{URL::to('/public/admin')}}/js/custom.js?v={{ config('app.version') }}" type="text/javascript"></script>
<!--      <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
 -->
      <script src="{{URL::to('/public/admin')}}/js/jquery.notyfy.js?v={{ config('app.version') }}" type="text/javascript"></script>
     
        <script src="{{URL::to('/public/admin')}}/js/notyfy.init.js?v={{ config('app.version') }}" type="text/javascript"></script>
     

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
