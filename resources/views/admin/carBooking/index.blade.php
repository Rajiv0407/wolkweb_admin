
            <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Car Booking</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Car Booking</li>
                        </ol>
                    </nav>
                </div>
                <div class="formWrapper">
                <form action="javascript:void(0);" method="post" id="s_carbooking" class=""> 
                <div class="filterWrapper">
                    <div class="form filterWrapper__l">
                        <div class="form-group">
                            <label for="Manufacture">Booking Id</label>
                            <input type="text" class="form-control" id="bookingId" placeholder="Booking Id">
                        </div>
                        <div class="form-group">
                            <label for="Model">Customer Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Customer Name">
                        </div>
                        <div class="form-group">
                            <label for="Model">Customer Email Id</label>
                            <input type="text" class="form-control" id="email" placeholder="Customer Email Id">
                        </div>
                        <div class="form-group">
                            <label for="Model">Mobile No.</label>
                            <input type="text" class="form-control" id="mobileNumber" placeholder="Mobile No">
                        </div>
                        <div class="form-group">
                            <label for="oName">Car Name</label>
                            <input type="text" class="form-control" id="carName" placeholder="Car Name">
                        </div>
                        <div class="form-group">
                            <label for="status">Booking From Date</label>
                            <input type="date" id="fromDate" class="form-control" placeholder="Booking From Date">
                        </div>
                        <div class="form-group">
                            <label for="status">Booking To Date </label>
                            <input type="date" id="toDate" class="form-control" placeholder="Booking To Date">
                        </div>
                        <div class="form-group">
                            <label for="status">Payment Type</label>
                            <select name="paymentType" id="paymentType" class="form-control">
                                <option value="">Select</option>
                                <option value="1">Credit Card</option>
                                <option value="2">Debit Card</option>
                                <option value="3">Net Banking</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Payment Status</label>
                            <select name="paymentStatus" id="paymentStatus" class="form-control">
                                <option value="">Select</option>
                                <option value="Success">Success</option>
                                <option value="Failed">Failed</option>
                            </select>
                        </div>
                        <div class="d-flex">
                             
                            <a href="javascript:void(0);" onclick="searchNType()" class="search-btn">
                                <i class="bi bi-search"></i><span>Search</span>
                            </a>
                            <a href="javascript:void(0);" onclick="resetSearchForm()" class="search-btn clear-btn ml-5px">
                                <i class="bi bi-eraser-fill"></i><span>Clear</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
</div>

                <div class="table-area car_booking_tbl">
                    <table class="table table-responsive" id="dataTable">
                        <thead>
                            <tr role="row">
                                <th scope="col">#</th>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Customer Details</th>
                                <th scope="col">Car Name</th>
                                <th scope="col">Pick Up From</th>
                                <th scope="col">Return To</th>
                                <th scope="col">Booking Date</th>
                                <th scope="col">Return Date</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Payment Type</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Photos</th>
                                <th scope="col">Photos</th>
                                <th scope="col">booking date</th>
                                <th scope="col">return date</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    
                </div>
        

<!-- car image -->
<div class="modal fade right_side" id="view_img" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Car Images</h5>
                <div class="cross-btn">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" id="vehicleIdModal">
                
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
      columnDefs: [  {
                    "aTargets": [0],
                    "mRender": function(data, type, full){
                      
                        return '<th scope="row"><a href="'+baseUrl+'/administrator/dashboard#car_booking_detail/'+full['id']+'" onclick="vehicleBookingDetail('+full['id']+',3)"><i class="bi bi-chevron-right"></i></a></th> ';
                    }


                }, {
                     "aTargets": [2],
                    "visible": false
                }, {
                     "aTargets": [14],
                    "visible": false
                }, {
                     "aTargets": [15],
                    "visible": false
                } ,{
                     "aTargets": [16],
                    "visible": false
                },{
                     "aTargets": [3],
                      "visible": false
                },
                {
                     "aTargets": [4],
                      "mRender": function(data, type, full){

                        var action = full['user_name']+'<br>('+full['mobile_Number']+')<br>'+full['user_email'] ;                      
                       
                       return action ;
                    }
                }
                  ,{

                    "aTargets": [13],
                    "mRender": function(data, type, full){

                        var action = '<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_img" onclick="viewVehicleImage('+full['id']+')">View</a>' ;                      
                       
                       return action ;
                    }

                } ,{

                    "aTargets": [12],
                    "mRender": function(data, type, full){

                        var action = '<div class="sucess">'+full['paymentStatus']+'</div>' ;                      
                       
                       return action ;
                    }

                }            

                ],

            ajax: {
                      url: '{!! URL::asset('carBooking_datatable') !!}',
                    },
             columns : [
             
                        { data: 'id' },
                        { data: 'id0' },
                        {data: 'user_name'},
                        {data: 'user_email'},
                        {data: 'mobile_Number'},
                        {data: 'carName'},
                        { data: 'pickupTo' },
                        { data: 'returnTo' },
                        { data: 'bookingDate'},
                        { data: 'returnDate' },
                        { data: 'amount' },
                        { data: 'paymentType'} ,
                        { data: 'paymentStatus'} ,
                        { data: 'vehicleId'},
                        { data: 'ptype'} ,
                        { data: 'bookingDate_'} ,
                         { data: 'returnDate_'} 
         
        
          ],

        });
      $k('.input-group-addon').click(function() {
        $k(this).prev('input').focus();
    });
         
         });




function viewVehicleImage(bookingId){
    
      $.ajax({
        type:"POST",
        url:baseUrl+'/carManagement/viewVehicleImage',
        data:{"bookingId":bookingId},
       
        beforeSend:function()
        {
            ajax_before();
        },
        success:function(html)
        {
            ajax_success() ;
           $('#vehicleIdModal').html(html);
        
        }
        });
}

function resetSearchForm(){

    var table = $('#dataTable').DataTable();
    document.getElementById("s_carbooking").reset();
    carBookingManagement();
     //$('#dataTable').DataTable().ajax.reload();        
  
}

  function searchNType(){

        var bookingId=$("#bookingId").val(); 
        var name=$("#name").val();
        var email=$("#email").val(); 
        var mobileNumber=$("#mobileNumber").val(); 
        var carName=$("#carName").val();
        var paymentType=$("#paymentType").val(); 
        var paymentStatus=$("#paymentStatus").val(); 
        var fromDate=$("#fromDate").val();
        var toDate=$("#toDate").val();
        var carName = $('#carName').val();

     if(bookingId){
     
          $('#dataTable').DataTable().column(1).search(bookingId).draw();
    }

     if(name){
   
          $('#dataTable').DataTable().column(2).search(name).draw();
    }
   
     if(email){
   
          $('#dataTable').DataTable().column(3).search(email).draw();
    }

     if(mobileNumber){
   
          $('#dataTable').DataTable().column(4).search(mobileNumber).draw();
    }

       
    //  if(carName){
   
    //       $('#dataTable').DataTable().column(7).search(carName).draw();
    // }
     if(paymentType){
   
          $('#dataTable').DataTable().column(14).search(paymentType).draw();
    }
     if(paymentStatus){
   
          $('#dataTable').DataTable().column(12).search(paymentStatus).draw();
    }

    // fromDate  
     if(fromDate){
   
          $('#dataTable').DataTable().column(15).search(fromDate).draw();
    }

     if(toDate){
   
          $('#dataTable').DataTable().column(16).search(toDate).draw();
    }

    if(carName!=''){
        $('#dataTable').DataTable().column(5).search(carName).draw();
        
    }
   
}

</script>