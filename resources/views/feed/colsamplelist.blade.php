<x-app-layout>
	<x-slot name="header">
		Feed - {{$col}}  minta lista
		
	</x-slot>

	
	<ul>
		@if(!empty($list))
			@foreach($list as $item)
				<li>{{$item}}</li>
			@endforeach
		@endif
	</ul>
</x-app-layout>