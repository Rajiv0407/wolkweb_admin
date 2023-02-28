 <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel AJAX Pagination with JQuery</h2>
            </div>
         
        </div>
    </div>
<div id="product_container">
       @include('presult')
</div>

<script>
//  $(window).on('hashchange', function() {
//         if (window.location.hash) {
//             var page = window.location.hash.replace('#', '');
//             if (page == Number.NaN || page <= 0) {
//                 return false;
//             }else{
//                 getData(page);
//             }
//         }
//     });
// $(document).ready(function()
// {
//      $(document).on('click', '.pagination a',function(event)
//     {
//         $('li').removeClass('active');
//         $(this).parent('li').addClass('active');
//         event.preventDefault();
//         var myurl = $(this).attr('href');
//        var page=$(this).attr('href').split('page=')[1];
//        getData(page);
//     });
// });
// function getData(page){
//         $.ajax(
//         {
//             url: '?page=' + page,
//             type: "get",
//             datatype: "html",
//             // beforeSend: function()
//             // {
//             //     you can show your loader 
//             // }
//         })
//         .done(function(data)
//         {
//             console.log(data);
            
//             $("#product_container").empty().html(data);
//             location.hash = page;
//         })
//         .fail(function(jqXHR, ajaxOptions, thrownError)
//         {
//               alert('No response from server');
//         });
// }
  </script>
