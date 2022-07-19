@if(!empty($mapelnya))
@foreach($mapelnya as $mapel)
<option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
@endforeach
@endif