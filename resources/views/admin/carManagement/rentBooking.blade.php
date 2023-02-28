<div class="table-area">
                                <table class="table" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Booking Id</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Customer Details</th>
                                            <th scope="col">Pick Up From</th>
                                            <th scope="col">Return To</th>
                                            <th scope="col">Booking Date & Time</th>
                                            <th scope="col">Return Date & Time</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Payment Type</th>
                                            <th scope="col">Payment Status</th>
                                            <th scope="col">Photos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                         
                                    </tbody>
                                </table>
                              
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
                      var type='<?php echo $type ; ?>' ;
                      var link = '' ;
                      if(type==1){
                        link='vehicle_booking_detail' ;
                      }else if(type==2){
                        link='customer_booking_detail' ;
                      }else{
                        link='car_booking_detail' ;
                      }

                        return '<th scope="row"><a href="'+baseUrl+'/administrator/dashboard#'+link+'/'+full['id']+'" onclick="vehicleBookingDetail('+full['id']+','+type+')"><i class="bi bi-chevron-right"></i></a></th> ';
                    }


                }, {
                     "aTargets": [2],
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

                    "aTargets": [12],
                    "mRender": function(data, type, full){

                        var action = '<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_img" onclick="viewVehicleImage('+full['id']+')">View</a>' ;                      
                       
                       return action ;
                    }

                } ,{

                    "aTargets": [11],
                    "mRender": function(data, type, full){

                        var action = '<div class="sucess">'+full['paymentStatus']+'</div>' ;                      
                       
                       return action ;
                    }

                }            

                ],

            ajax: {
                      url: '{!! URL::asset('carManagement/carBookingData/'.$vehicleId.'/'.$type) !!}',
                    },
             columns : [
             
                        { data: 'id' },
                        { data: 'id0' },
                        {data: 'user_name'},
                        {data: 'user_email'},
                        {data: 'mobile_Number'},
                     
                        { data: 'pickupTo' },
                        { data: 'returnTo' },
                        { data: 'bookingDate'},
                        { data: 'returnDate' },
                        { data: 'amount' },
                        { data: 'paymentType'} ,
                        { data: 'paymentStatus'} ,
                        { data: 'vehicleId'} 
         
        
          ],

        });
      $k('.input-group-addon').click(function() {
        $k(this).prev('input').focus();
    });
         
         });


// function vehicleBookingDetail(bookingId){

//       ajaxCsrf();

//         $.ajax({
//         type:"POST",
//         url:baseUrl+'/carManagement/bookingDetail',
//         data:{"bookingId":bookingId},
       
//         beforeSend:function()
//         {
//             ajax_before();
//         },
//         success:function(html)
//         {
//             ajax_success() ;
//            $('.main_site_data').html(html);
        
//         }
//         });
// }

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

</script>