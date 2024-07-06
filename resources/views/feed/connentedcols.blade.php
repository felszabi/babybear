<div>
	<ul>
		<li>unconnected = not paired</li>
		<li>value = paired to column</li>
		<li>attr-id = paired to attribute</li>
		<li>false = should not paired</li>
	</ul>
</div>
<form action="{{route('feed.updatecols',$feed)}}" method="post">
	@csrf
    @method('post')
    <x-bs-primary-button value="Mentés" />
    <table>
    	<thead>
	    	<tr>
	    		<th>Mező</th>
	    		<th>Kapcsolat</th>
	    	</tr>	
    	</thead>
    	<tbody>
    		@foreach($connentedcols as $connentedcol => $connentedcolval)
    		
    		<tr class="border-bottom border-info">
    			<td>
    				{{$connentedcol}}
    			</td>
    			<td class="connentedcol">
    				<div>
    					<input type="text" name="{{$connentedcol}}"   value="{{$connentedcolval}}" class="form-control connect-input">
    					<a target="_blank" href="{{route('feed.colsamplelist',[$feed,$connentedcol])}}" class="btn btn-secondary btn-sm">Súgó</a>
    				</div>
    				<div class="mb-2 row">
    					<div class="col">
    						<x-bs-select-input :list="$columns" :simplearray="true" />
    					</div>
    					<div class="col">
    						<a class="btn btn-secondary">Másol</a>
    					</div>
    				</div>
    				<div class="mb-2 row">
    					
    					<div class="col">
    						<x-bs-select-input :list="$attributes" :simplearray="false" />
    					</div>
    					<div class="col">
    						<a class="btn btn-secondary">Másol</a>
    					</div>
    				</div>
    			</td>
    		</tr>
    		@endforeach
    	</tbody>
    </table>
    <x-bs-primary-button value="Mentés" />
</form>
<script type="module">
        
	$(".connentedcol .btn").on('click',function(){
		var choosenCol = $('select',$(this).closest('.row')).val();
		if(Math.floor(choosenCol) == choosenCol && $.isNumeric(choosenCol)){
			choosenCol = 'attr-id-' + choosenCol + '-' + $('select',$(this).closest('.row')).find(':selected').text().trim();
		}
		$('input.connect-input',$(this).closest('td.connentedcol')).val(choosenCol);
	});

</script>