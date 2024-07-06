@props(['id','name','value'=>'','label','messages','type'=>'text'])

<div {{ $attributes->merge(['class' => 'mb-3 mx-3']) }}>
  <label for="{{ $id }}" class="form-label">{{ $label }}</label>
  <div class="input-group">
    <input type="{{$type}}" name="{{ $name }}" value="{{$value}}" class="form-control" id="{{ $id }}" aria-describedby="{{ $label }}">
  </div>
  @if ($messages)
  <div class="form-text" id="{{ $id }}-error">
  		@foreach ((array) $messages as $message)
            {{ $message }}<br>
        @endforeach
  </div>
  @endif
</div>