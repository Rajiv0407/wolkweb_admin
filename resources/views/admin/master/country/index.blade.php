          <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper d-flex align-items-center justify-content-between ">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Master</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()" >Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Master</li>
                            <li class="breadcrumb-item active" aria-current="page">Country</li>
                        </ol>
                    </nav>

                    <!---data-bs-toggle="modal" data-bs-target="#add_body"   -->
                    <div class="rightButton">
                        <a href="javascript:void(0);" onclick="showModal('add_body456')" class="border-btn d-flax" ><i class="bi bi-plus"></i><span>Add Country</span></a>
                    </div>
                </div>
                <form action="javascript:void(0);" method="post" id="featureSearchForm">
                <div class="filterWrapper">
                    <div class="form filterWrapper__l s_I">
                       
                         <div class="form-group">
                            <label for="Manufacture">Title</label>
                            <input type="text" class="form-control" id="fTitleS" placeholder="Title">
                        </div> 
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="fStatus_S" id="fStatus_S" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </div>
                        <div class="d-flex">
                            <a href="javascript:void(0);" onclick="searchFeatures();"  class="search-btn">
                                <i class="bi bi-search"></i><span>Search</span>
                            </a>
                            <a href="javascript:void(0);" class="search-btn clear-btn ml-5px" onclick="clearCountry()">
                                <i class="bi bi-eraser-fill"></i><span>Clear</span>
                            </a>
                        </div>
                 
                    </div>
                </div>
                       </form>
                <div class="table-area Country_tble">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">Id </th>
                                <th scope="col">Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                    <!-- <div class="table-footer">
                        <p><span>Total Record</span>:<span>10</span></p>
                    </div> -->
                </div>
        


<div class="modal fade right_side" id="add_body456" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout add_country_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Country</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" method="post" id="fuelTypeForm">
           
                <div class="form modal-form">
                    <div class="form-group">
                        <label for="Manufacture">Title</label>
                         <input type="text" name="cTitle" id="cTitle"  class="form-control" placeholder="Title">
                         <span id="err_cTitle" class="err" style="color:red"></span>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="javascript:void(0);"  onclick="submitCountry()" class="search-btn">Submit</a>
                    <a href="javascript:void(0);" id="cancelBType" onclick="cancelFeature()" class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade right_side" id="edit_body" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout edit_body_typ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Body Type</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" id="editBodyTypeMb">                
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

     $(document).ready(function($k){
   
        datatablePagination($k); 

         $('#dataTable').DataTable({
              processing: true,
              serverSide: true,
              pageLength: 10,
              retrieve: true,
              sDom: 'lrtip',
              lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
              sPaginationType: "bootstrap",
              "aaSorting": [[ 0, 'desc' ]],   
              columnDefs: [  
                        {
                            "aTargets": [0],
                            "visible": false
                        } ,{
                            "aTargets": [2],
                            "mRender" : function(data, type, full){ 
                              var action='' ;
                               var className='' ;

                            if(full['status']==1){
                              className='activeCountry' ;
                            }else{
                              className='inactiveCountry' ;
                            }

                            action+='<span class="'+className+'">'+full['status_']+'</span>';

                            return action ;
                            }
                        } ,


                          {
                            "aTargets": [3],
                            "mRender" : function(data, type, full){

                                // data-bs-toggle="modal" data-bs-target="#edit_body"

                                var action = '<div class="align-items-center d-flex"> <div class="more_n"> <i class="bi bi-three-dots-vertical" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i> <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink"> <li><a class="dropdown-item" href="javascript:void(0);"  onclick="editCountry('+full["id"]+')" >Edit</a></li> <li><a class="dropdown-item" href="javascript:void(0);" onclick="ConfirmDelete('+full['id']+')" >Delete</a></li> </ul> </div> <div> <label class="switch">  ' ;

                            if(full['status']==1){
                                 action +='<input type="checkbox" onclick="changeCountryStatus('+full['id']+')" checked>' ;
                             }else{
                                action +='<input type="checkbox" onclick="changeCountryStatus('+full['id']+')" >' ;
                             }

                              action+='<span class="slider"></span> </label> </div> </div> '  ;

                               return action ;
                            }

                        
                        }
                        
                        ],

                    ajax: {
                              url: '{!! URL::asset('masterController/country_datatable') !!}',
                            },
                     columns : [            
                                { data:'id' },
                                { data:'title' },
                                { data:'status_' },
                                { data:'status' }
                  ],

                });

              $k('.input-group-addon').click(function() {
                $k(this).prev('input').focus();
            });
                 
        });

    function ConfirmDelete(id) {
        
        if(confirm("Are you sure ?")) {
            delete_country(id);
        }
    }

    function delete_country(id){

             ajaxCsrf();

        $.ajax({

        type:"POST",
        url:baseUrl+'/deleteCountry',
        data:{"id":id},
        dataType:'json',
        beforeSend:function()
        {
             ajax_before();
        },
        success:function(res)
        {

             ajax_success() ;

        if(res.status==1){
      
          $('#dataTable').DataTable().ajax.reload();                
          statusMesage('Deleted successfully','success');
        }else{
           statusMesage('Something went wrong','error');
        }
        }

        });

    }



    function submitCountry(){

         ajaxCsrf();
        var cTitle=$('#cTitle').val();

        $('.err').html('');

        if(cTitle==''){
            $('#err_cTitle').html('Please enter title.')
        } else {

            
            var formData=new FormData($('#fuelTypeForm')[0]);


              $.ajax({
                type: "POST",
                url: baseUrl + '/saveCountry',
                data:formData ,
                dataType:'json',
                cache:false,
                contentType:false,
                processData:false,
                beforeSend: function () {
                       ajax_before();
                },
                success: function(html){
                 ajax_success() ;
                 // console.log(html);
                    if(html.status==1){
                        $('#fuelTypeForm')[0].reset();  
                        $('#add_body456').modal('hide'); 
                        $('.modal-backdrop').remove();    
                         removeModelOpen();
                        $('#dataTable').DataTable().ajax.reload();

                          statusMesage('Save country successfully','success');
                      }else{
                          statusMesage(html.message,'error');
                      }
                
                        }
                    });   

        }
    }

    function cancelFeature(){

        $('#fTitle').val('');
        $('#featureIcon').val('');
    }

    function editCountry(updatedId){   

        ajaxCsrf();
        $('#edit_body').modal('show') ;
        $.ajax({
            type: "POST",
            url: baseUrl +'/editCountry',
            data:{'updatedId':updatedId} ,           
            cache: 'FALSE',
            beforeSend: function () {
                   ajax_before();
            },
            success: function(html){
             ajax_success() ;
               $('#editBodyTypeMb').html(html) ;
                }
            });   
    }

    function updateCountry(){
      var editFTitle= $('#editCTitle').val() ;
      ajaxCsrf();
      $('.err').html('');
      if(editFTitle==''){
          $('#err_editCTitle').html("Please enter title");
      }else{
        $('.err').html('');
        var formData=new FormData($('#editCountryForm')[0]);
        

        $.ajax({
            type: "POST",
            url: baseUrl +'/updateCountry',
            data:formData ,
            dataType:'json',
            cache: 'FALSE',
                contentType:false,
                processData:false,
            beforeSend: function () {
                   ajax_before();
            },
            success: function(html){
             ajax_success() ;
             if(html.status==1){

                 modalHide_('edit_body'); 
                // $('.modal-backdrop').hide();   
                $('#dataTable').DataTable().ajax.reload();
                statusMesage('Successfully updated','success');
                // $('#edit_fuel').modal('hide');  
                           
             }else{
                 statusMesage('Something went wrong','error');
             }
              
            
                    }
            });      




      }
     
        
    }

function changeCountryStatus(id){

    ajaxCsrf();

    $.ajax({
        type:"POST",
        url:baseUrl+'/countryStatus',
       data:{"id":id},
       dataType:'json',
  beforeSend:function()
    {
        ajax_before();
    },
success:function(res)
{
     ajax_success() ;
if(res.status==1){
   var table = $('#dataTable').DataTable();
    table.draw( false );
     statusMesage('Shanged status successfully','success');
  }else{
     statusMesage('Something went wrong','success');
  }
}

});
}


function clearCountry(){

    var table = $('#dataTable').DataTable();
    document.getElementById("featureSearchForm").reset();
  countryList();
     //$('#dataTable').DataTable().ajax.reload();        
  
}



   function searchFeatures(){

        var fTitleS=$("#fTitleS").val();
        var fStatus_S=$("#fStatus_S").val();
  
     if(fTitleS){
     
          $('#dataTable').DataTable().column(1).search(fTitleS).draw();
    }
     if(fStatus_S){
   
          $('#dataTable').DataTable().column(3).search(fStatus_S).draw();
    }
   
  }



</script>