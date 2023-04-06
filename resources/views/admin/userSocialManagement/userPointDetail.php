<?php //echo "<pre>"; print_r($user_point); exit; ?>
<div class="carManagement__wrapper">
                <div class="breadcrumbWrapper">
                    <nav aria-label="breadcrumb">
                    <h3 class="fs-5 m-0 fw-500"><?php echo isset($user_point->name)?$user_point->name:''; ?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/administrator/dashboard#index" onclick="dashboard()">Home</a></li>
                            <li class="breadcrumb-item"><a href="#usersocialpoint" onclick="userPointList()">User Point </a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Points Detail</li>
                        </ol>
                    </nav>
                </div>

 
                <div class="dashCard">
                                <div class="card">
                                    <div class="card-header">
                                        <!-- <div>Facebook Data</div>
                                        <div>Facebook Data</div>
                                        <div>Facebook Data</div>
                                        <div>Facebook Data</div> -->

                                        <!-- <div class="d-inline-block" style="float:right;"><a href="javascript:void(0);"  class="border-btn" data-bs-toggle="modal" data-bs-target="#editDetailVehicle"><i class="bi bi-pencil-square"></i> Edit</a></div> -->
                                    </div>
                    <div >
                       
                    
                        <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Social Field</th>
      <th scope="col">Social Data</th>
      <th scope="col">Social Weightage</th>
      <th scope="col">Social Point</th>
    </tr>
  </thead>
  <tbody>
    <?php
              if(!empty($userPointW)){   
                foreach($userPointW as $val){  
                    $point=isset($val->point)?$val->point:0 ;              
                  
                ?>
                        <tr>
                            <th scope="row"><?php echo $val->id ; ?></th>
                            <td><?php echo $val->title ; ?></td>
                            <?php if($val->social_type==1){  ?>
                                <td><?php echo isset($user_fb[$val->data_column_name])?$user_fb[$val->data_column_name]:0 ; ?></td>

                            <?php   }else if($val->social_type==2){  ?>
                                <td><?php echo isset($user_insta[$val->data_column_name])?$user_insta[$val->data_column_name]:0 ; ?></td>
                            <?php    }else if($val->social_type==3){  ?>
                                <td><?php echo isset($user_titktok[$val->data_column_name])?$user_titktok[$val->data_column_name]:0 ; ?></td>
                            <?php   } ?>
                            <td><?php echo $val->weightage ; ?></td>
                            <td><?php echo $point ; ?></td>
                        </tr>

              <?php } } ?>
    
    
    <tr>
      <th scope="row" colspan="4" style="text-align:right;">Total Points</th>      
      <td><?php echo $user_point->total_point ; ?></td>
    </tr>
    <tr>
      <th scope="row" colspan="4" style="text-align:right;">Points Avg</th>      
      <td><?php echo $user_point->avg_point ; ?></td>
    </tr>
  </tbody>
</table>

                    
                     
                    </div>  

                    
</div>
</div>


