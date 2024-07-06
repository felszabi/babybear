<x-app-layout>
	<x-slot name="header">
		Feedek
		<x-bs-primary-link href="{{route('feed.create')}}">Új feed</x-bs-primary-link>
	</x-slot>

	<div class="mx-auto">
		{{ $listitems->links() }}
	</div>

	<table class="mx-auto table table-primary">
		<thead>
			<tr>
				<th>id</th>
				<th>name</th>
				<th>src</th>
				<th>filename</th>
				<th>keycolumn</th>
				<th>connentedcols</th>
				<th>pricemod</th>
				<th>action</th>
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
			
				<td class="text-truncate">{{ $item->src }}<x-bs-file-input :feed="$item" :src="$item->src" name="feedfile" /></td>
			
				<td class="text-truncate">{{ $item->filename }} {{$uploaded?'ok':''}}</td>
			
				<td class="text-truncate">{{ $item->keycolumn }}</td>
			
				<td class="text-truncate"><button class="btn btn-primary btn-sm {{ json_decode($item->connentedcols,true)==null	? 'disabled' : ''}} connentedcols-btn">Mező-Kapcsolat</button></td>
			
				<td class="text-truncate">{{ $item->pricemod }}</td>
				
				<td>
					<x-bs-formaction method="DELETE" action="{{route('feed.destroy',$item)}}">Törlés</x-bs-formaction>

				</td>
			</tr>
			<tr data-id="{{ $item->id }}">
				<td colspan="8">
					<ul  class="list-group list-group-horizontal">
						<li  class="list-group-item">
							<button class="edit-btn btn btn-primary btn-sm">módosít</button>
						</li>
						@if(strlen($item->src) > 2)
						<li class="list-group-item">
							<a href="{{route('feed.download',$item)}}" class="btn btn-primary btn-sm">Frissítés</a>
						</li>
						@endif
						<li class="list-group-item">
							<a href="{{route('feed.load',$item)}}" class="btn btn-primary btn-sm">Betöltés</a>
						</li>
					</ul>
				</td>
			</tr>
			<tr id="item-row-{{$item->id}}">
				<td colspan="8">
					<div class="work"></div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<script type="module">
        
            $(".connentedcols-btn").on('click',function(){
            	var itemId = $(this).closest('tr').data('id');
                $('#item-row-'+itemId+' .work').load("{{route('feed')}}/connentedcols/"+itemId);
            });

            $(".edit-btn").on('click',function(){
            	var itemId = $(this).closest('tr').data('id');
                $('#item-row-'+itemId+' .work').load("{{route('feed')}}/edit/"+itemId);
            });
    </script>
	<div class="mx-auto">
		{{ $listitems->links() }}
	</div>

</x-app-layout>