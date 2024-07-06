@props(['src','name', 'feed'])

@if(strlen($src) < 3)
<form action="{{route('feed.upload',$feed)}}" method="post" enctype="multipart/form-data">
	@csrf
	@method('post')
	<div class="mb-3">
	  <label for="formFileSm" class="form-label">Manuális feed feltöltés</label>
	  <input class="form-control form-control-sm" id="formFileSm" name="{{$name}}" type="file">
	</div>
	<x-bs-primary-button value="Feltölt" />
</form>
@endif