
<div class="carManagement__wrapper">
    <div class="breadcrumbWrapper">
        <nav aria-label="breadcrumb">
            <h3 class="fs-5 m-0 fw-500">Booking Details</h3>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()">Home</a></li>
               @if($type==1):
                <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#car_management" onclick="carManagement()">Car Management </a></li>
                <li class="breadcrumb-item active" aria-current="page"> <a href="{{URL::to('/')}}/administrator/dashboard#car_detail/{{$vehicleId}}" onclick="carDetail('{{$vehicleId}}')">Car Detail </a>  </li>    
               @elseif($type==2):
               <li class="breadcrumb-item active" aria-current="page"> <a  href="{{URL::to('/')}}/administrator/dashboard#customer_management" onclick="customerManagement()">Customer Management </a>  </li>
                <li class="breadcrumb-item active" aria-current="page"> <a href="{{URL::to('/')}}/administrator/dashboard#customer_detail/{{$carBookingInfo->userId}}" onclick="customerDetail('{{$carBookingInfo->userId}}')">{{$carBookingInfo->user_name}} </a>  </li>
                
                @else:
                  <li class="breadcrumb-item active" aria-current="page"> <a href="{{URL::to('/')}}/administrator/dashboard#car_booking" onclick="carBookingManagement()">Car Booking </a>  </li>
                @endif

                <li class="breadcrumb-item active" aria-current="page">Booking Details</li>
            </ol>
        </nav>
    </div>
                <div class="filterWrapper">
                    <div class="bcc__wrapper">
                        <div>
                            <h3>Booking Details</h3>
                            <p>
                                <span>Booking Id : </span>
                                <span>#{{$carBookingInfo->id}}</span>
                            </p>
                            <p>
                                <span>Booking Date :</span>
                                <span>{{$carBookingInfo->bookingDate}}</span>
                            </p>
                            <p>
                                <span>Payment Type : </span>
                                <span>{{$carBookingInfo->paymentType}}</span>
                            </p>
                            <p>
                                <span>Payment Status :</span>
                                <span>{{$carBookingInfo->paymentStatus}}</span>
                            </p>
                        </div>
                        <div>
                            <h3>Customer Details</h3>
                            <p>
                                <span>Name : </span>
                                @if($carBookingInfo->user_name=='')
                                <span>N/A</span>
                                @else
                               
                                 <span>{{$carBookingInfo->user_name}}</span>
                                @endif
                            </p>
                            <p>
                                <span>Email Id : </span>
                                @if($carBookingInfo->user_email=='')
                                    <span>N/A</span>
                                 @else
                                   <span>{{$carBookingInfo->user_email}}</span>
                                 @endif
                              
                            </p>
                            <p>
                                <span>Mobile Number : </span>
                                @if($carBookingInfo->mobile_Number=='')
                                <span>N/A</span>
                                @else 
                                <span>{{$carBookingInfo->mobile_Number}}</span>
                                @endif
                                
                            </p>
                            <p>
                                <span>Address :</span>
                                @if($carBookingInfo->address=='')
                                <span>N/A</span>
                                @else
                                <span>{{$carBookingInfo->address}}</span>
                                @endif
                                
                            </p>
                        </div>
                        <div>
                            <h3>Car Owner Details</h3>
                            <p>
                                <span>Name : </span>
                                @if($carOwnerInfo->name=='')
                                 <span>N/A</span>
                                @else
                                 <span>{{$carOwnerInfo->name}}</span>
                                @endif
                               
                            </p>
                            <p>
                                <span>Email Id : </span>
                                @if($carOwnerInfo->email=='')
                                    <span>N/A</span>
                                @else
                                    <span>{{$carOwnerInfo->email}}</span>
                                @endif
                                
                            </p>
                            <p>
                                <span>Mobile Number : </span>
                                @if($carOwnerInfo->mobile_Number=='')
                                <span>N/A</span>
                                @else
                                 <span>{{$carOwnerInfo->mobile_Number}}</span>
                                @endif
                               
                            </p>
                            <p>
                                <span>Address :</span>
                                @if($carOwnerInfo->address=='')
                                 <span>N/A</span>
                                @else
                                 <span>{{$carOwnerInfo->address}}</span>
                                @endif
                               
                            </p>
                        </div>
                    </div>
                    <div class="table-area">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Car Details</th>
                                    <th>Pick Up From</th>
                                    <th>Return To</th>
                                    <th>Booking Date & Time</th>
                                    <th>Return Date & Time</th>
                                    <th>Total Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="align-items-center d-flex gap-2">
                                            <img src="{{$carBookingInfo->vImg}}" alt="">
                                            <h6 class="m-0">{{$carBookingInfo->vehicleName}}</h6>
                                        </div>
                                    </td>
                                    <td>{{$carBookingInfo->pickupTo}}</td>
                                    <td>{{$carBookingInfo->returnTo}}</td>
                                    <td>{{$carBookingInfo->bookingDate}}</td>
                                    <td>{{$carBookingInfo->returnDate}}</td>
                                    <td>{{$carBookingInfo->amount}} </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2">
                                        <div class="table-footer-n">
                                            <p><span>Subtotal:</span><span>{{$carBookingInfo->amount}}</span></p>
                                            <p><span>Total Amount:</span><span>{{$carBookingInfo->amount}}</span></p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    