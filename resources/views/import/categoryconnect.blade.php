
<x-app-layout>
	<x-slot name="header">
		Kategória társítás 
	</x-slot>

<table class="mx-auto table table-primary">
		<thead>
			<tr>
				<th>név</th>
				<th>feed név</th>
			</tr>
		</thead>
		<tbody>
			<tr id="categories">
				<td class="category">
					<x-bs-select-input :list="$categories" />
				</td>
				<td class="feed-category" data-cat="{{$category}}">{{ $category }}
				</td>
			</tr>
			<tr>
				<td colspan="2" id="work">
					<form method="post" action="{{ route('category.add',['feed'=> $feed, 'nth' => $nth]) }}" class="mt-6 space-y-6">
						@csrf
				        @method('post')
					<x-bs-text-input id="category" messages="" name="category" value="category" label="Kategória" />
					<x-bs-text-input type="hidden" id="feedcategory" messages="" name="feedcategory" value="{{$category}}" label="Feed Kategória" />
					<x-bs-primary-button value="Hozzáad" />
				</form>
				</td>
			</tr>
		</tbody>
	</table>
	<script type="module">
		$('#categories').on('change',function(){
			var sel = $('#categories .category select').find(':selected').text();
			$("#category").val(sel);
			$("#feedcategory").val($("#categories .feed-category").data('cat'));
		});
	</script>


</x-app-layout>