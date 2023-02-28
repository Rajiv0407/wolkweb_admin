         <inupt type="hidden" name="hidden_page" id="hidden_page" value="1" />
         <inupt type="text" name="review_vehicleId" id="review_vehicleId" value="<?php echo $vehicleId ; ?>" />

           <div class="r_c_wrp">
            <div class="r_wrp filterWrapper r_wrp" id="product_container">
             @include('admin/rating/ajax_rating')
           </div>
           
           
         </div> 


         <script type="text/javascript">

          $(document).ready(function()
          {
            

            function fetch_data(page){

              var vehicleId = '<?php echo $vehicleId ; ?>' ;
              
              $.ajax({
                type:"get",
                url:baseUrl+"/ajax_carReviews?page="+page,
                data:{'vehicleId':vehicleId},
                success:function(data){
                  $('#product_container').html(data);a
                }

              });
            }



            $(document).on('click','.pagination a', function(e){
              e.preventDefault();
              var page = $(this).attr('href').split('page=')[1] ;
              fetch_data(page) ;
            });

          });

          
          window.onload = function(){
            ajax_success() ;
          }

        </script>



        