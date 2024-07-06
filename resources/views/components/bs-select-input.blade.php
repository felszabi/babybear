@props(['list','simplearray'=>false])

<select class="form-select inline" aria-label="selectlabel">
  @foreach($list as $listitemkey => $listitemvalue)
  <option value="{{$simplearray? $listitemvalue : $listitemvalue->id}}">{{$simplearray?$listitemvalue:$listitemvalue->name}}</option>
  @endforeach
</select>