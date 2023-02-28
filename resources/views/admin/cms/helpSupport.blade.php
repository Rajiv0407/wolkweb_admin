  
            <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Help</h3>
                        <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()" >Home</a></li>
                            <li class="breadcrumb-item">CMS</li>
                            <li class="breadcrumb-item active" aria-current="page">Help</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <form action="javascript:void(0);" method="post" id="helpForm" name="helpForm">
                    <div class="form-group mb-3">
                        <label for="cms_type" >Description</label>
                        <textarea name="helpSupport" id="helpSupport" cols="30" rows="4" class="ckeditor textarea_control w-100 "><?php echo isset($description)?$description:'' ; ?></textarea>
                    </div>
                    <div class="d-flex max-w-250">
                        <a href="javascript:void(0);" class="search-btn" onclick="helpSave()"> Update</a> 
                        <a href="javascript:void(0);" onclick="helpCancel()"  class="search-btn clear-btn ml-5px"> Cancel </a>
                    </div>
                </form>
                </div>
            </div>
<script>
        $('.ckeditor').ckeditor();
       
    </script> 
<script type="text/javascript">


    function helpCancel(){
        $('#privacyPolicy').val('') ;
    }

    function helpSave(){

         ajaxCsrf();  

         var fromData=$("#helpForm").serialize() ;

          $.ajax({
            type: "POST",
            url: baseUrl+'/saveHelp',
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
        
        