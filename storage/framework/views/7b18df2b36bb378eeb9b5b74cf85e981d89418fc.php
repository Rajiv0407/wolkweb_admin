<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Lesgo</title>
      <link rel="stylesheet" type="text/css" href="<?php echo e(URL::to('/public/admin')); ?>/css/style.css">
      <link rel="stylesheet" type="text/css" href="<?php echo e(URL::to('/public/admin')); ?>/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
      <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
   </head>
   <body>
    

    <section class="lg_login__box">
      

      <div class="container-fluid">
        
        <div class="row">
        
        <div class="col-md-7 p-0">
          
          <div class="lg_login_img">
            
            <img src="<?php echo e(URL::to('/public/admin/')); ?>/images/login_car.svg" class="img-fluid">

          </div>

        </div>

        <div class="col-md-5 p-5">
          
          <div class="account-box">
               <div class="account-logo-box">
                  <h2 class="text-uppercase text-center">
                     <!-- <a href="" class="text-success">
                     <span><img src="<?php echo e(URL::to('/public/admin/')); ?>/images/logo.png?v1" alt=""></span>
                     </a> -->
                  </h2>
               </div>
               <div class="main-login-box account-content">
                  <div class="login-bg-box login">
                     <div class="login-box-right" id="dvLogin">
                        <div id="pnl">
                          <div class="lg_login_heading">
                          <h2>Welcome Back!</h2>
                          <h5 class="mb-4">Please sign in to continue.</h5>
                        </div>
                           <div class="panel-body innerAll">
                              <form name="loginform" id="loginform" action="javascript:void(0);" method="post" onsubmit="loginValidation()" autocomplete="off">
                                 <div class="form-group form-group_copy">
                                  <label>UserName</label>
                                    <!-- <i class="bi bi-envelope-fill"></i> -->
                                    <input type="text" placeholder="Enter user name" class="form-control" id="txtUserName" onkeyup="removeError()" name="txtUserName" onclick="remove_valid(this.id)" onkeypress="remove_valid(this.id)" value="<?php echo e($userName); ?>" autofocus>
                                    <span id="error_txtUserName" class="errorbox"></span>
                                 </div>
                                 <div class="form-group form-group_copy">
                                    <label>Password</label>
                                    <!-- <i class="bi bi-lock-fill"></i> -->
                                     
                                    <input type="password" placeholder="Password" class="form-control" id="txtPassword" onkeyup="removeError()" name="txtPassword" onclick="remove_valid(this.id)" onkeypress="remove_valid(this.id)" value="<?php echo e($userPassword); ?>">
                                    <span id="error_txtPassword" class="errorbox"></span>
                                 </div>
                                 <div class="form-group" style="margin:25px 0px 0px;">
                                    <div class=""><!--== case ===-->
                                       <label class="con">
                                       <span>Remember me?</span>
                                       <input type="checkbox" name="rememberMe" value="1">
                                       <span class="checkmark"></span>
                                       </label>
                                    </div>
                                    <div id="loadingGif2" style="display: none;"><img src="<?php echo e(URL::to('/public/admin')); ?>/images/loader.gif"></div>
                                    <div class="btnlogin">
                                       <button class="btn btn-primary" style="margin-top:20px;" id="btnLogin" type="submit" style="background-color: #204d74;">
                                       Sign In
                                       </button>
                                       <div id="error_invalidpass" class="errorbox"></div>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

        </div>

      </div>

      </div>


    </section>



            
         





      <script type="text/javascript">
         function loginValidation(){   
         
                 var txtUserName = document.loginform.txtUserName.value;
                 var txtPassword = document.loginform.txtPassword.value;
                 $("#error_txtUserName").html("");
                 $("#error_txtPassword").html("");
                 document.loginform.txtUserName.style.borderColor = "";
                 document.loginform.txtPassword.style.borderColor = "";
                 if (txtUserName == "") {
                     document.loginform.txtUserName.focus() ;    
                     document.loginform.txtUserName.style.borderColor = "red";
                     $("#error_txtUserName").html("User Name is required.");
                     return false;
                 }
                 else if (txtPassword == "") {
                     document.loginform.txtPassword.focus() ;
                     document.loginform.txtPassword.style.borderColor = "red";
                     $("#error_txtPassword").html("Password is required");
                     return false;
                 }
                 else {   
                     loginchk();
                 }
                 
         }
         
         function remove_error(){
         $('.err').html('');
         }
         function removeError(){
         $('.err').html('');
         }
         function remove_valid(id) {
         
                 $('#'+id).css('border-color', '');
                 $('#'+id).siblings('.errorbox').html('');
                 $('#err_msg').html('');
                 $('#error_txtfusername').html('');
           }
         
         function loginchk() {
         
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });
         
         var baseUrl = "<?php echo e(url('/')); ?>";
         
         $.ajax({
         type: "POST",
         url: baseUrl + '/administrator/do_login',
         data: $('#loginform').serialize(),
         cache: 'FALSE',
         beforeSend: function () {
                $('#loadingGif2').show();
         },
         success: function (html) {
         //return false ;
           $('#loadingGif2').hide();
             
         if (html=='fail')
         {
         $("#error_invalidpass").html("Incorrect username or Password");  
         }
         else{
         
         window.location = baseUrl + '/administrator/dashboard#index';
         
         }
                 }
             });
         }
         
      </script>
      <script type="text/javascript" src="https://code.jquery.com/jquery.min.js"></script>
      <script src="<?php echo e(URL::to('/public/admin/js')); ?>/bootstrap.min.js" type="text/javascript"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
      <script src="<?php echo e(URL::to('/public/admin/js')); ?>/custom.js" type="text/javascript"></script>
   </body>
</html><?php /**PATH D:\xampp\htdocs\walkofwebapi\resources\views/admin/login.blade.php ENDPATH**/ ?>