<x-app-layout>
	<x-slot name="header">
		Import FEED-ből
	</x-slot>

	<div class="mx-auto">
		{{ $listitems->links() }}
	</div>

	<table class="mx-auto table table-primary">
		<thead>
			<tr>
				<th>id</th>
				<th>name</th>
				<th>downloaded</th>
				<th>pricemod</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($listitems as $item)
		@php
		$uploaded = in_array('feedasset/'.$item->filename,$files);
		@endphp
			<tr data-id="{{ $item->id }}">
				<td class="text-truncate">{{ $item->id }}</td>
			
				<td class="text-truncate">{{ $item->name }}</td>
			
				<td class="text-truncate">{{ $item->downloaded }} {{$uploaded?'ok':''}}</td>
			
				<td class="text-truncate">{{ $item->pricemod }}</td>
			
			</tr>
			<tr data-id="{{ $item->id }}">
				<td colspan="4">
					@if($uploaded)
					<ul class="list-group list-group-horizontal">
						<li class="list-group-item">
							<a href="#" class="edit-btn btn btn-primary btn-sm">kifutott termékek törlése/inaktiválása</a>
							
						</li>
						
						<li class="list-group-item">
							<a href="#" class="btn btn-primary btn-sm">árak/készletek frissítése</a>
						</li>
						
						<li class="list-group-item">
							<a href="{{route('import.new',['feed'=>$item->id])}}" class="btn btn-primary btn-sm">uj termékek hozzáadása</a>
						</li>

						<li class="list-group-item">
							<a href="{{route('products.renameallcategories',['feed'=>$item->id])}}" class="btn btn-primary btn-sm">termék kategóriák frissítése</a>
						</li>
					</ul>
					@else
					{{ __('Fájl nincs feltöltve!') }}
					@endif
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<script type="module">
        
    </script>
	<div class="mx-auto">
		{{ $listitems->links() }}
	</div>

</x-app-layout>