<!doctype html>
<html lang="en">

<head>

    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--====== Title ======-->
    <title>walkofweb | walking with stars</title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="assets/images/favicon-32x32.png" type="image/png">

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!--====== Fontawesome css ======-->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!--====== Magnific Popup css ======-->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">

    <!--====== Slick css ======-->
    <link rel="stylesheet" href="assets/css/slick.css">

    <!--====== Default css ======-->
    <link rel="stylesheet" href="assets/css/default.css">

    <!--====== Style css ======-->
    <link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body>

    <!--====== OFFCANVAS MENU PART START ======-->

    <div class="off_canvars_overlay">

    </div>
          
  

    <section id="features" class="intro-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-title text-center">
                        <!-- <h3 class="title">User List</h3> -->
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
               
                <div class="col-lg-12">
                    <h3>User List</h3>
                   
                    <table class="table">
                        <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($userList)){ 

                            foreach ($userList as $key => $value) { ?>
                                <tr>
                            <td width="20px"><?php echo $value->name ; ?></td>
                            <td width="20px"><?php echo $value->email ; ?></td>
                             <td width="100px">
                            <a  style="margin-left:10px; " href="<?php echo url('/').'/fbProfileConnect/'.$value->encryption ; ?>" >Connect With Facebook</a>
                            <br>
                            <a  style="margin-left:10px; " href="<?php echo url('/').'/fbConnect/'.$value->encryption ; ?>">Connect With Insta Business Account</a>
                            <br>
                          <!--   <a  style="margin-left:10px; " target="_blank" href="<?php //echo 'https://www.walkofweb.net/'.$value->encryption ; ?>" >Connect With Tiktok</a> -->
                            <br>
                            <a href="JavaScript:void(0);" style="margin-left:10px; "  data-toggle="modal" data-target="#exampleModal" onclick="getUserPoints('<?php echo $value->id ; ?>','<?php echo $value->name; ?>')">View</a>
                             </td>
                        </tr>
                         <?php 
                                }
                        ?> 
                       
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

  

<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">       
        <h3 class="modal-title" id="exampleModalLabel" style="text-align:center;">User Points Detail</h3>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 style="text-align:center;">User Name : <span id="userN"></span></h4>
      </div>
      <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
      <div class="modal-body" id="socialData">
       
      </div>
     
    </div>
  </div>
</div>
   
   <script type="text/javascript">
    var baseUrl = "{{ url('/') }}";
        function ajaxCsrf(){
         $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('#token').val()
           }
        });
        }

       function getUserPoints(id,name){
         $('#userN').text(name);
       ajaxCsrf();

        $.ajax({
        type: "POST",
        url: baseUrl+'/userPoints',
        data:{"id":id,"name":name},       
        cache: 'FALSE',
        beforeSend: function () {
       // ajax_before();
        },
        success: function(html){
       // ajax_success() ;
           $('#socialData').html(html);

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

   </script>

</body>

</html>