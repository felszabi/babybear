@props(['status'=>'success'])

<div class="alert alert-{{ $status }}" role="alert">
  {{ $slot }}
</div>