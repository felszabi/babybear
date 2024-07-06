<x-app-layout>
	<x-slot name="header">
	</x-slot>
	<div class="mx-auto">

		<x-bs-pagination :paginator="$products" />
	</div>
	@if($productskeys != false)
<div class="table-responsive">
	<table class="mx-auto w-100 table table-primary ">
		<thead>
			<tr>
				@foreach ($productskeys as $key)
				<th>{{$key}}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
		@foreach ($products as $product)
			<tr>
				@foreach ($productskeys as $key)
				<td>{{ $product->$key}}</td>
				@endforeach
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
	@endif
	<div class="mx-auto">
		<x-bs-pagination :paginator="$products" />
	</div>

</x-app-layout>