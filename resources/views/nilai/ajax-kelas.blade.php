@if(!empty($jadwalnya))
@foreach($jadwalnya as $jadwal)
<option value="{{ $jadwal->id }}">{{ $jadwal->kelas->kelas }} {{ $jadwal->kelas->rombel }} - {{ $jadwal->mapel->nama }}
</option>
@endforeach
@endif