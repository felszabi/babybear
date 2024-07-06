@props(['action','method'=>'POST'])

<form action="{{$action}}" method="post" onsubmit="return confirm('Biztos vagy benne?');">
	@csrf
	@method($method)
	<button type="submit" class="btn btn-secondary btn-sm">{{$slot}}</button>
</form>

