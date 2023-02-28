<form action="javascript:void(0);" method="post" id="editCarForm" >         
<div class="modal-form form">
   <input type="hidden" name="updatedId" id="updatedId" value="{{$vehicleInfo->id}}">
    <div class="form-group">
        <label for="">Manufacturer</label>
        <input type="text" class="form-control" name="car_manufacture" id="car_manufacture" placeholder="Enter Manufacturer" value="{{ $vehicleInfo->manufacturer }}">
        <span id="err_manufacture" class="err" style="color:red"></span>
    </div>
    <div class="form-group">
        <label for="">Model</label>
        <input type="text" class="form-control" name="car_model" id="car_model" value="{{ $vehicleInfo->model }}" placeholder="Enter Model">
        <span id="err_car_model" class="err" style="color:red"></span>
    </div>
    <div class="form-group">
        <label for="">No. of Seats</label>
        <input type="number" class="form-control" name="car_seats" id="car_seats" value="{{ $vehicleInfo->nSeat }}" placeholder="Enter Seats No.">
        <span id="err_car_seats" class="err" style="color:red"></span>
    </div>
    <!-- onkeypress="return onlyNumbers(event)" -->
    <div class="form-group">
        <label for="">No. of Doors</label>
        <input type="number" class="form-control" name="car_doors" id="car_doors" value="{{ $vehicleInfo->nDoor }}" placeholder="Enter doors no.">
        <span id="err_car_doors" class="err" style="color:red"></span>
    </div>
    <div class="form-group">
        <label for="">Fuel Type</label>
        <select class="form-control" name="car_fuleType" id="car_fuleType">
            <option value="">Select</option>
            @foreach($fuelType as $fType)
            <option value="{{ $fType->id }}" <?php echo ($vehicleInfo->fuelType==$fType->id)?'selected':'' ; ?> > {{ $fType->title }}</option>
            @endforeach
        </select>
        <span id="err_fuel_type" class="err" style="color:red"></span>
    </div>
    <div class="form-group">
        <label for="">Transmission Type</label>
        <select  class="form-control" name="car_transmissionType" id="car_transmissionType">
            <option value="">Select</option>
             @foreach($transType as $tranType)
<option value="{{ $tranType->id }}" <?php echo ($vehicleInfo->transmissionType==$tranType->id)?'selected':'' ; ?> >{{ $tranType->title }}</option>
             @endforeach
        </select>
        <span id="err_trans_type" class="err" style="color:red"></span>
    </div>
    <div class="form-group">
        <label for="">Body Type</label>
        <select  class="form-control" name="car_bodyType" id="car_bodyType">
            <option value="">Select</option>
             @foreach($bodyType as $bType)
              <option value="{{ $bType->id }}" <?php echo ($vehicleInfo->bodyType==$bType->id)?'selected':'' ; ?> >{{ $bType->title }}</option>
             @endforeach

        </select>
        <span id="err_body_type" class="err" style="color:red"></span>
    </div>
                    <div class="form-group">
                        <label for="">Price</label>
                        <input type="number" class="form-control" name="car_price" id="car_price" value="{{ $vehicleInfo->price }}" placeholder="Enter Price">
                        <span id="err_price" class="err" style="color:red"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Is Popular </label>
                        <select name="isPopular" id="isPopular" class="form-control">
                            <option value="">Select</option>
                            <option value="1" {{ ($vehicleInfo->isPopular==1)?'selected':''  }} >Yes</option>
                            <option value="0" {{ ($vehicleInfo->isPopular==0)?'selected':''  }} >No</option>
                        </select>
                        <span id="err_isPopular" class="err" style="color:red"></span>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="javascript:void(0);" onclick="updateDetailCar();" class="search-btn" >Update</a>
                    <a href="javascript:void(0);" class="search-btn clear-btn" data-bs-dismiss="modal" onclick="cancelForm('editCarForm');">Cancel</a>
                </div>
            </form>

