@props(['paginator'])


@if($paginator->hasPages())
<nav aria-label="...">
  <ul class="pagination">
    <li class="page-item {{ $paginator->previousPageUrl() !== null ? '' : 'disabled'}}">
      <a class="page-link" href="{{$paginator->previousPageUrl()}}" tabindex="-1">Előző</a>
    </li>
    
    @if($paginator->lastPage() < 10)
	    @for($i=1; $i<=$paginator->lastPage();$i++)
	    <li class="page-item {{ $i==$paginator->currentPage()? 'active': '' }}"><a class="page-link" href="{{$paginator->url($i)}}">{{$i}}</a></li>
	    @endfor
    @else
    	@if($paginator->currentPage() > 2)
    	<li class="page-item"><a class="page-link" href="{{$paginator->url(1)}}">{{1}}</a></li>
    	@endif

    	@if($paginator->currentPage() > 1 && $paginator->currentPage() < $paginator->lastPage())
    		@for($i=$paginator->currentPage()-1; $i<=$paginator->currentPage()+1;$i++)
		    <li class="page-item {{ $i==$paginator->currentPage()? 'active': '' }}"><a class="page-link" href="{{$paginator->url($i)}}">{{$i}}</a></li>
		    @endfor
    	@else
    		@if($paginator->currentPage() == 1)
	    		@for($i=1; $i<=3;$i++)
			    <li class="page-item {{ $i==$paginator->currentPage()? 'active': '' }}"><a class="page-link" href="{{$paginator->url($i)}}">{{$i}}</a></li>
			    @endfor
    		@endif
    		@if($paginator->currentPage() == $paginator->lastPage())
	    		@for($i=$paginator->currentPage()-2; $i<=$paginator->lastPage();$i++)
			    <li class="page-item {{ $i==$paginator->currentPage()? 'active': '' }}"><a class="page-link" href="{{$paginator->url($i)}}">{{$i}}</a></li>
			    @endfor
    		@endif
    	@endif

    	@if($paginator->currentPage() < $paginator->lastPage()-1)
    	<li class="page-item "><a class="page-link" href="{{$paginator->url($paginator->lastPage())}}">{{$paginator->lastPage()}}</a></li>
    	@endif
    @endif
    <li class="page-item {{ $paginator->nextPageUrl() !== null ? '' : 'disabled'}}">
      <a class="page-link" href="{{$paginator->nextPageUrl()}}">Következő</a>
    </li>
  </ul>
</nav>
@endif