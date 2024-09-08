@props(['name'])

@error($name)
<p class="text-danger"><small>{{$message}}</small></p>
@enderror