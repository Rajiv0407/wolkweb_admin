
            <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper d-flex align-items-center justify-content-between" >
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Contact Support</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact Support</li>
                        </ol>
                    </nav>
                    
                </div>

<form class="" id="n_serarchForm" action="javascript:void(0);" > 
                <div class="filterWrapper">

                    <div class="form filterWrapper__l">
                         <div class="form-group">
                            <label for="Manufacture">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                        </div>
                         <div class="form-group">
                            <label for="Manufacture">Phone Number</label>
                            <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" placeholder="Phone Number">
                        </div>
                        <div class="form-group">
                            <label for="Manufacture">Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                        </div>
                        
                        <div class="form-group">
                            <label for="oName">Subject</label>
                            <input type="text" name="subject" id="subject" value="" placeholder="Subject" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="oName">Message</label>
                            <input type="text" name="message" id="message" value="" placeholder="Message" class="form-control">
                        </div>

                        <div class="d-flex">
                            <a href="javascript:void(0);"  onclick="searchNType()" class="search-btn">
                                <i class="bi bi-search"></i><span>Search</span>
                            </a>
                            <a href="javascript:void(0);" onclick="resetSearchForm()" class="search-btn clear-btn ml-5px">
                                <i class="bi bi-eraser-fill"></i><span>Clear</span>
                            </a>
                        </div>
                        
                    </div>
                </div></form>
                <div class="table-area">
                    <table class="table" id="dataTable">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                    <!-- <div class="table-footer">
                        <p><span>Total Record</span>:<span>10</span></p>
                    </div> -->
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
               },
               
               {
                    "aTargets": [6],
                    "mRender": function(data, type, full){

                        var action = '<td> <div class="align-items-center d-flex"> <div class="more_n"><i class="bi bi-three-dots-vertical show" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="true"></i> <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" data-popper-placement="top-end" style="position: absolute; left: 0px; top: auto; margin: 0px; right: auto; bottom: 0px; transform: translate(1066px, -38px);"><li><a class="dropdown-item" onclick="ConfirmDelete('+full['id']+')" href="javascript:void(0);">Delete</a></li> </ul></div> ' ;
                        //<div> <label class="switch">
                        // if(full['status']=='1'){
                        //      action +='<input type="checkbox" onclick="changeNStatus('+full['id']+')" checked>' ;
                            
                        // }else{
                        //      action +='<input type="checkbox" onclick="changeNStatus('+full['id']+')" >' ;
                           
                        // }<span class="slider"></span> </label> </div>
                       
                       action+=' </div> </td>'  ;

                       return action ;
                    }

                }

                ],

            ajax: {
                url:'{!! URL::asset('contactUs_datatable') !!}',
                    },
             columns : [            
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'phone_number' },
                        { data: 'email' },
                         { data: 'subject'},
                          { data: 'message' },
                                 
                
          ],

        });
      $k('.input-group-addon').click(function() {
        $k(this).prev('input').focus();
    });
         
});

function ConfirmDelete(id) {
    
    if(confirm("Are you sure ?")) {
        delete_contactus(id);
    }
}

    function delete_contactus(id){
             ajaxCsrf();
        $.ajax({type:"POST",
        url:baseUrl+'/delete_contactus',
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
        //carManagement();
          $('#dataTable').DataTable().ajax.reload();                
          statusMesage('deleted successfully','success');
        }else{
           statusMesage('something went wrong','error');
        }
        }

        });

    }

function resetSearchForm(){

    var table = $('#dataTable').DataTable();
    document.getElementById("n_serarchForm").reset();
  contactSupport();
     //$('#dataTable').DataTable().ajax.reload();        
  
}



  function searchNType(){
        var name=$('#name').val();
        var phoneNumber=$('#phoneNumber').val();
        var email=$("#email").val();
        var subject=$("#subject").val();
        var message=$("#message").val();
       

       if(name){
     
          $('#dataTable').DataTable().column(1).search(name).draw();
    }

    if(phoneNumber){
     
          $('#dataTable').DataTable().column(2).search(phoneNumber).draw();
    }
    
     if(email){
     
          $('#dataTable').DataTable().column(3).search(email).draw();
    }

     if(subject){
   
          $('#dataTable').DataTable().column(4).search(subject).draw();
    }
   
     if(message){
   
          $('#dataTable').DataTable().column(5).search(message).draw();
    }
  
}
   

</script>
