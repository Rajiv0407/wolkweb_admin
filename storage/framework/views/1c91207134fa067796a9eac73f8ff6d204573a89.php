       <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Privacy & Policy</h3>
                        <ol class="breadcrumb">
                          
                             <li class="breadcrumb-item"><a href="<?php echo e(URL::to('/')); ?>/administrator/dashboard#index" onclick="dashboard()" >Home</a></li>
                            <li class="breadcrumb-item">CMS</li>
                            <li class="breadcrumb-item active" aria-current="page">Privacy & Policy</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <form action="javascript:void(0);" method="post" id="privacyPolicyForm" name="privacyPolicyForm">
                    <div class="form-group mb-3">
                        <label for="cms_type">Description</label>
                        <textarea name="privacyPolicy" id="privacyPolicy" cols="30" rows="4" class="ckeditor textarea_control w-100 "><?php echo isset($description)?$description:'' ; ?></textarea>
                    </div>
                    <div class="d-flex max-w-250">
                        <a href="javascript:void(0);" onclick="submitPrivacyPolicy()" class="search-btn"> Update</a> 
                        <a href="javascript:void(0);" onclick="privacyPolicyCancel()" class="search-btn clear-btn ml-5px"> Cancel </a>
                    </div>
                </form>
                </div>
            </div>

  <script>
        $('.ckeditor').ckeditor();
       
    </script> 

<script type="text/javascript">

    function privacyPolicyCancel(){
        $('#privacyPolicy').val('') ;
    }

    function submitPrivacyPolicy(){

         ajaxCsrf();  

         var fromData=$("#privacyPolicyForm").serialize() ;

          $.ajax({
            type: "POST",
            url: baseUrl+'/savePrivacyPolicy',
            data:fromData ,
            cache: 'FALSE',
            dataType:'json',
            beforeSend: function () {
                   ajax_before();
            },
            success: function(html){
             ajax_success() ;
             if(html.status==1){
                   statusMesage('Updated successfully','success');
               }else{
                    statusMesage('something went wrong','error') ;
               }
                
            
                    }
                });
    }


</script>
        <?php /**PATH C:\xampp\htdocs\walkofweb_admin\resources\views/admin/cms/privacyPolicy.blade.php ENDPATH**/ ?>