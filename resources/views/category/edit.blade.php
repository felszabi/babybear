
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
				<td class="feed-category" data-cat="{{$category->foreign_name}}">{{ $category->foreign_name }}
				</td>
			</tr>
			<tr>
				<td colspan="2" id="work">
					<form method="post" action="{{ route('category.update',['category'=> $category]) }}" class="mt-6 space-y-6">
						@csrf
				        @method('post')
					<x-bs-text-input id="category" messages="" name="new_category_name" value="{{$category->name}}" label="Kategória" />
					<x-bs-text-input type="hidden" id="feedcategory" messages="" name="feedcategory" value="{{$category->foreign_name}}" label="Feed Kategória" />
					<x-bs-primary-button value="Módosít" />
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