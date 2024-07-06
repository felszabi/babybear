@props(['value','name','id','checked'=>false])

<div class="form-check mx-3">
  <input class="form-check-input" name="{{$name}}" type="checkbox" value="" id="{{$id}}" {{ $checked!==false?'checked':'' }} >
  <label class="form-check-label" for="{{$id}}">
    {{ $value }}
  </label>
</div>