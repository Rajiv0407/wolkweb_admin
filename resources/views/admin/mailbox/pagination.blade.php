<!-- @if ($paginator->lastPage() > 1)
<ul class="pagination">
    <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
        <a href="{{ $paginator->url(1) }}">Previous</a>
    </li>
  @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
            <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
        </li>
    @endfor 
    <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
        <a href="{{ $paginator->url($paginator->currentPage()+1) }}" >Next</a>
    </li>
</ul>
@endif -->

<style type="text/css">
    a.disabled {
  pointer-events: none;
  cursor: default;
}
</style>

<?php 

$limitR = $limitR ;
$lastRecord = 0 ;
$totalRec = $inbox_list->total() ;
$currentPage_ =$paginator->currentPage() ;
if($paginator->currentPage()==1){
    $sRecord=$paginator->currentPage() ;
    $lastRecord = $limitR ;
}else{

    $sRecord=((($paginator->currentPage() - 1) * $limitR) + 1) ;
    $lastRecord = $paginator->currentPage() * $limitR ;
}


 if($lastRecord > $totalRec){
    $lastRecord=$totalRec ;
 }



 ?>

@if ($paginator->lastPage() > 1)
<a href="javascript:void(0);"><span>{{$sRecord}}-{{$lastRecord}}</span> of <span>{{ $inbox_list->total() }}</span></a>
<a class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}" href="javascript:void(0);" onclick="fetch_data('{{$paginator->currentPage()-1}}')"  ><i class="bi bi-arrow-left"></i></a>
<a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}" href="javascript:void(0);" onclick="fetch_data('{{$paginator->currentPage()+1}}')"><i class="bi bi-arrow-right"></i></a>
@endif

