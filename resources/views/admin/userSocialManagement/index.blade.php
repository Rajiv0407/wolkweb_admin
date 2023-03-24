<div class="carManagement__wrapper">
                <div class="breadcrumbWrapper d-flex align-items-center justify-content-between">
                    <nav aria-label="breadcrumb">
                        <h3 class="fs-5 m-0 fw-500">User Social Point</h3>
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()" >Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Social Point</li>
                        </ol>
                    </nav>
                </div>
                <form class="" id="n_serarchForm1" action="javascript:void(0);" > 
                <div class="filterWrapper">
                    <div class="form filterWrapper__l">
                        <div class="form-group">
                            <label for="Model">Title</label>
                            <input type="text" class="form-control" id="name" placeholder="Name">
                        </div>  
                        <!-- <div class="form-group">
                            <label for="oName">Mobile Number</label>
                            <input type="text" class="form-control" id="cus_mobileNumber" placeholder="Mobile Number">
                        </div> -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="" id="point_status" class="form-control">
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>
                        </div>
                        <div class="d-flex">
                              
                            <a href="javascript:void(0);" class="search-btn" onclick="searchNType()">
                                <i class="bi bi-search"></i><span>Search</span>
                            </a>
                             <a href="javascript:void(0);" class="search-btn clear-btn ml-5px" onclick="resetSearchForm()">
                                <i class="bi bi-eraser-fill"></i><span>Clear</span>
                            </a>
                        </div>
                         
                    </div>
                </div>
            </form>
                <div class="table-area">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col" width="10%">Total Count</th>
                                <th scope="col" width="10%">Avg Count</th>
                                <th scope="col" width="10%">Status</th>
                                <th scope="col">Action</th>  
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
      columnDefs: [ 
                {
                    "aTargets": [0],
                    "visible":false
                },
                {
                            "aTargets": [4], 
                            "mRender" : function(data, type, full){   
                            var action='' ;
                            var className='' ;
                            if(full['status']==1){
                              className='activeNFor' ;
                            }else{
                              className='inactiveNFor' ;
                            }
                            action+='<span class="'+className+'">'+full['status_']+'</span>';
                            return action ;
                            }
                        } ,
                {
                    "aTargets": [5],
                     "mRender": function(data, type, full){  
                        var response ='<td><div class="align-items-center d-flex"><div class="more_n"></div><div> <label class="switch">' ;   
                        if(full['status']=='1'){
                             response +='<input type="checkbox" onclick="changeUsrStatus('+full['id']+')" checked>' ;     
                        }else{
                             response +='<input type="checkbox" onclick="changeUsrStatus('+full['id']+')" >' ;    
                        }
                        response+='<span class="slider"></span> </label> </div> </div> </td>'  ;
                        return response ;
                    }
                }
                ],

            ajax: {
                      url: '{!! URL::asset('userPointDatatable') !!}',
                    },
             columns : [
                       { data: 'id'},
                        { data: 'name'},
                        { data: 'total_point' },
                        { data: 'avg_point' },
                        { data: 'status' },
                        { data: 'status_' }, 
          ],
        });
      $k('.input-group-addon').click(function() {
        $k(this).prev('input').focus();
    });      
});
function cancelFeature(){
$('#name').val('');
$('#point_status').val('');
}
function changeUsrStatus(id){
    ajaxCsrf();
    $.ajax({
        type:"POST",
        url:baseUrl+'/userPointStatus',  
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
     statusMesage('changed status successfully','success');
    }else{
     statusMesage('something went wrong','success');
    }
    }

    });
}
function resetSearchForm(){
    var table = $('#dataTable').DataTable();
    document.getElementById("n_serarchForm1").reset();
  userPointList();      
     //$('#dataTable').DataTable().ajax.reload();        
}  
function searchNType(){
      var name=$("#name").val();
      var point_status=$("#point_status").val();
        if(name){
                $('#dataTable').DataTable().column(1).search(name).draw();
        }
        if(point_status){
                $('#dataTable').DataTable().column(4).search(point_status).draw();
        }
}
</script>