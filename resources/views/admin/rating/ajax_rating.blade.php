        <?php 

            $data = $ratingReview->toArray() ;
            $totalRecord = isset($data['total'])?$data['total']:0 ;

            if($totalRecord > 0){
           
         ?> 

          @foreach ($ratingReview as $val)
            <?php 

              $status=isset($val->status)?$val->status:'' ;

              if($status==0){
                $cls='pendingStatus' ;
              }else if($status==1){
                 $cls='approveStatus' ;
              }else if($status==2){
                $cls='rejectStatus' ;
               
              }else{
                $cls='';
              }


             ?>
                <div class="r_bx">
                          <div>
                            <img src="{{$val->userImg}}" alt="">
                        </div>
                    <div class="rating_list">
                        <div class="d-flex align-items-center justify-content-between ">
                            <div class="d-flex gap-3 mb-2 r_bx_1 align-items-center">
                                <h4 class="m-0">{{$val->userName}}</h4>
                                <span class="m-0 bg_pending <?php echo $cls ; ?>" id="reviewStatus{{$val->id}}" >{{$val->reviewStatus}}</span>
                            </div>
                            <div>
                                <div class="align-items-center more_n d-flex">
                                    <i class="bi bi-three-dots-vertical" type="button" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                     
                                         <li><a class="dropdown-item" href="javascript:void(0);" onclick="approveReview('{{$val->id}}')">Approve</a></li>
                                          <li><a class="dropdown-item" href="javascript:void(0);" onclick="rejectReview('{{$val->id}}')">Reject</a></li>
                                     
                                       
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="r_name">
                            <p class="fw-500">{{$val->vehicleName}}</p>
                        </div>
                        <div class="icon_Dt">
                            <p class="d-flex gap-2"><i class="bi bi-calendar-date fs-5"></i> <span class="">{{ $val->reviewDate }}</span></p>
                        </div>
                        

                        <div class="d-flex align-items-center gap-3">
                            <?php for($i=0;$i<5;$i++){ ?>
                                <?php if($val->rating >=$i+1){ ?>
                            <i class="bi bi-star-fill bg_main "></i>
                               <?php }else{ ?> 
                                <i class="bi bi-star bg_main "></i>
                               <?php } ?>
                             <?php } ?>
                        </div>
                        <div>
                            <p>{{$val->review}}</p>
                        </div>
                    </div>
                        </div>
                            @endforeach
                <?php } else { ?> 
                        <div class="no-rating">
                            <img src="{{URL::to('/')}}/public/admin/images/no_data.png" alt="">
                            <p>No Data Found </p>
                        </div>
                    <?php } ?>
    {!! $ratingReview->render() !!}
                    
                