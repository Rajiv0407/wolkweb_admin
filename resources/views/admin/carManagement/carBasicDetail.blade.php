<?php 
  // print_r($featureInfo);

  // Array ( [0] => stdClass Object ( [featureId] => 1 [title] => Audio [isSelected] => 0 ) [1] => stdClass Object ( [featureId] => 2 [title] => Sunroof [isSelected] => 0 ) [2] => stdClass Object ( [featureId] => 3 [title] => Airbags [isSelected] => 0 ) [3] => stdClass Object ( [featureId] => 4 [title] => GPS [isSelected] => 0 ) [4] => stdClass Object ( [featureId] => 5 [title] => Bluetooth [isSelected] => 1 ) )

 ?> 
<div class="dashCard c_Dtl">
                                <div class="card">
                                    <div class="card-header">
                                        <div>Basic Details</div>
                                        <div class="d-inline-block"><a href="javascript:void(0);" onclick="editDetailVehicle('{{$vehicleId}}')" class="border-btn" data-bs-toggle="modal" data-bs-target="#editDetailVehicle"><i class="bi bi-pencil-square"></i> Edit</a></div>
                                    </div>
                    <div class="card-body">
                        <p><span>Manufacturer : </span><span>{{$carInfo->manufacturer}}</span></p>
                        <p><span>Model : </span><span>{{$carInfo->model}}</span></p>
                        <p><span>No. of Seats : </span><span>{{$carInfo->nSeat}}</span></p>
                        <p><span>No. of Doors : </span><span>{{$carInfo->nDoor}}</span></p>
                        <p><span>Transmission Type : </span><span>{{$carInfo->transType_}}</span></p>
                        <p><span>Body Type : </span><span>{{$carInfo->bodyType_}}</span></p>
                        <p><span>Fuel Type : </span><span>{{$carInfo->fuleType_}}</span></p>
                        
                        <p><span>Price : </span><span>{{$carInfo->price}} AED / Hr</span></p>

                        <p><span>Is Popular : </span>
                        @if($carInfo->isPopular==0)
                            <span>No</span>
                        @else 
                            <span>Yes</span>
                        @endif
                       </p>
                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <div>Features</div>
                                        <div class="d-inline-block"><a href="javascript:void(0);" class="border-btn" data-bs-toggle="modal" data-bs-target="#edit_features"  onclick="editFeature('{{$vehicleId}}')"><i class="bi bi-pencil-square"></i> Edit</a></div>
                                    </div>
                                    <div class="card-body">
                                       
                                        @foreach ($featureInfo as $val)
                                        <p><span>{{$val->title}} : </span><span><?php echo ($val->isSelected)?'Yes':'No' ; ?></span></p>
                                        @endforeach
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="dashCard mt-3">
                                <div class="card">
                                    <form action="javascript:void(0);" method="post" id="updateDescriptionForm">
                                    <div class="card-header">
                                        Car Description
                                    </div>
                                    <input type="hidden" name="updateId" id="updateId" value="{{$vehicleId}}">
                                    <div class="card-body mt-3">
                                        <textarea name="vehicleDescr" id="vehicleDescr" cols="30" rows="4" class="form-control">{{$carInfo->description}}</textarea>
                                    </div>
                                    <div class="mt-2">
                                        <a href="javascript:void(0);" onclick="updateVehicleDesc('{{$vehicleId}}')" class="search-btn">Update</a>
                                       <!--  <a href="#" class="search-btn clear-btn" data-bs-dismiss="modal">Cancel</a> -->
                                    </div>
                                    </form>
                                </div>
                            </div>



