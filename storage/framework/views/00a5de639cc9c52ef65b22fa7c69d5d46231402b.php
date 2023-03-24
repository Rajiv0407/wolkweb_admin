<div class="headerWrapper">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="#">
                <img src="<?php echo e(URL::to('/public/admin')); ?>/images/logo.png" alt="">
            </a> -->
            <div class="navbarContent navbar-right align-items-center w-100 justify-content-between d-flex">
                <div class="toggle_btn">
                <i class="ri-menu-line"></i>
                </div>
                <ul class="nav navbar-nav gap-20 align-items-center">

                    <li>
                        Welcome <span class="fw-500">Admin</span>
                    </li>

                  <li><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#adminChangePassword" onclick="adminChangePwd()">Change Password</a></li>
                    <?php if(Session::has('admin_session')): ?>
                    <li>
                        <a href="<?php echo e(URL::to('/')); ?>/administrator/logout" class="fs-18 d-flex align-items-center gap-1">
                            <!-- <i class="bi bi-box-arrow-in-right fs-4"></i> -->
                            <span>Logout</span>
                        </a>
                    </li>
                    <?php endif; ?> 
                </ul>
            </div>
        </div>
    </nav>
</div>


<div class="hidden modal fade right_side" id="adminChangePassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout edit_body_typ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" method="post" id="adminChangePassword_"> 
               <!--  <input type="hidden" name="changeUserPwd" id="changeUserPwd"> -->
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="">New Password</label>
                        <input type="password" placeholder="Enter New Password" id="newAdminPassword" name="newAdminPassword" class="form-control">
                        <span class="err" id="err_newAdminPassword"></span>
                    </div>

                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" id="confirmAdminPassword" name="confirmAdminPassword" placeholder="Enter Confirm Password" class="form-control">
                         <span class="err" id="err_confirmAdminPwd"></span>
                    </div>
                </div>
                 <div class="mt-4">
                <a href="javascript:void(0);"  class="search-btn" onclick="updateAdminChangePwd()">Update</a>
                <a href="javascript:void(0);" class="search-btn clear-btn" data-bs-dismiss="modal"  onclick="cancelAdminChangePwd()" >Cancel</a>
            </div>
        </form>
            </div>
           
        </div>
    </div>
</div>

<script type="text/javascript">
    function adminChangePwd(){
        $("#adminChangePassword").prependTo("body");
    }
    function cancelAdminChangePwd(){
        $('#adminChangePassword_')[0].reset() ;
    }

    function updateAdminChangePwd(){
    
        var newPwd = $('#newAdminPassword').val();
        var confirmPwd = $('#confirmAdminPassword').val();

        $('.err').html('') ;
        if(newPwd==''){
            $('#err_newAdminPassword').html('Please enter new password') ;
        }else if(confirmPwd==''){
            $('#err_confirmAdminPwd').html('Please enter confirm password') ;
        }else if(newPwd!=confirmPwd){
            $('#err_confirmAdminPwd').html('both password must be matched') ;
        }else{

               var formData = $('#adminChangePassword_').serialize() ;

                 ajaxCsrf();

        $.ajax({
            type:"POST",
            url:baseUrl+'/changeAdminPassword',
            data:formData,
            dataType:'json',
            beforeSend:function()
            {
                 ajax_before();
            },
            success:function(res)
            {

                 ajax_success() ;

            if(res.status==1){
            $('.modal-backdrop').hide();      
            $('#adminChangePassword_')[0].reset();
            $('#adminChangePassword').modal('hide');
            $('#dataTable').DataTable().ajax.reload();                
              statusMesage('password updated successfully','success');
            }else{
               statusMesage('something went wrong','error');
            }
            }

            });
    }
 }
  
/* $('.toggle_btn').click(function(){
    $('.grid-container').toggleClass('collapse_grid_container');
 });*/


</script><?php /**PATH D:\xampp\htdocs\walkofwebapi\resources\views/includes/admin/header.blade.php ENDPATH**/ ?>