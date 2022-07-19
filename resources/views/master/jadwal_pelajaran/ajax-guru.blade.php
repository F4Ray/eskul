@if(!empty($gurunya))
@foreach($gurunya as $guru)
<option value="{{ $guru->id }}">{{ $guru->nama }}</option>
@endforeach
@endif