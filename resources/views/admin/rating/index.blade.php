
 @extends('includes.admin.template')

 @section('content') 

<script type="text/javascript">
     $(document).ready(function(){
        ajax_before();
     });
     


</script> 
            <div class="carManagement__wrapper">
                <div class="breadcrumbWrapper">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">Rating & Reviews</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">

                                
                           <a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()" >Home</a>

                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Rating & Reviews</li>
                        </ol>
                    </nav>
                </div>
                <form action="javascript:void(0);" method="post" id="reviewForm" class="form-control"> 
                <div class="filterWrapper">
                    <div class="form filterWrapper__l">
                        <div class="form-group">
                            <label for="Manufacture">Name</label>
                            <input type="text" class="form-control" id="search_name" placeholder="Name" value="">
                        </div>
                        <div class="form-group">
                            <label for="Model">Car Name</label>
                            <input type="text" class="form-control" id="search_carName" placeholder="Car Name">
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="car_status" id="car_status" class="form-control">
                                <option value="">Select</option>
                                <option value="Pending">Pending</option>
                                <option value="Approve">Approve</option>
                                <option value="Reject">Reject</option>
                            </select>
                        </div>
                        <div class="d-flex">
                            <a href="javascript:void(0);" class="search-btn" id="searchReview" >
                                <i class="bi bi-search"></i><span>Search</span>
                            </a>
                            <a href="javascript:void(0);" onclick="clearSearchForm()" class="search-btn clear-btn ml-5px">
                                <i class="bi bi-eraser-fill"></i><span>Clear</span>
                            </a>
                        </div>
                    </div>
                </div>
                <inupt type="hidden" name="hidden_page" id="hidden_page" value="1" />
            </form>

             
                     <div class="r_c_wrp">
                        <div class="r_wrp filterWrapper r_wrp" id="product_container">
                        @include('admin/rating/ajax_rating')
                        </div>
                        
                        
                    </div>   




<script type="text/javascript">

$(document).ready(function()
{
   
function fetch_data(page,name="",carName="",status=""){
  $.ajax({
    url:baseUrl+"/administrator/ajax_rating?page="+page+"&name="+name+"&carName="+carName+"&status="+status,
        success:function(data){
        $('#product_container').html(data);
    }

    });
}

$(document).on('click','#searchReview',function(){  

    var name = $('#search_name').val() ;
    var carName = $('#search_carName').val() ;
    var carStatus = $('#car_status').val() ;

    var page = $('#hidden_page').val();
      fetch_data(page,name,carName,carStatus);

});

$(document).on('click','.pagination a', function(e){
    e.preventDefault();
        var name = $('#search_name').val() ;
        var carName = $('#search_carName').val() ;
        var carStatus = $('#car_status').val() ;
        var page = $(this).attr('href').split('page=')[1] ;
    fetch_data(page,name,carName,carStatus) ;
});

});

   


function clearSearchForm(){
  $('#reviewForm')[0].reset();
  window.location = baseUrl+'/administrator/rating' ;
}



window.onload = function(){
    ajax_success() ;
}

</script>


 @endsection        


