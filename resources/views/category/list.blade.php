<x-app-layout>
	<x-slot name="header">
		Kategóriák
		
	</x-slot>

	
	<x-bs-pagination :paginator="$listitems" />
	<table class="mx-auto table table-primary">
		<thead>
			<tr>
				<th>id</th>
				<th>név</th>
				<th>feed név</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($listitems as $item)
		
			<tr data-id="{{ $item->id }}">
				<td class="text-truncate">{{ $item->id }}</td>
			
				<td class="text-truncate">{{ $item->name }}</td>
				
				<td class="text-truncate">{{ $item->foreign_name }}</td>
			
			</tr>
		@endforeach
		</tbody>
	</table>
	<x-bs-pagination :paginator="$listitems" />

</x-app-layout>