@extends('layouts.app')
@section('internalCSS')
<!-- <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
    integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap4.css') }}" />
<style>
.select2-selection__rendered {
    margin: 4.5px;
}
input[type="radio"]{
   appearance: none;
   border: 1px solid #d3d3d3;
   width: 30px;
   height: 30px;
   content: none;
   outline: none;
   margin: 0;
   box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}

input[type="radio"]:checked {
  appearance: none;
  outline: none;
  padding: 0;
  content: none;
  border: none;
}

input[type="radio"]:checked::before{
  /* position: absolute; */
  color: green !important;
  content: "\00A0\2713\00A0" !important;
  border: 1px solid #d3d3d3;
  font-weight: bolder;
  font-size: 21px;
}
</style>
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Absensi Guru</h1>
        </div>
        <div class="row">
            @if(count($errors) > 0 )
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    {{$errors->first()}}

                </div>
            </div>
            @endif
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    @if (Auth::user()->role->role == 'admin')
                    {{ __('Absensi Siswa') }}
                    @else (Auth::user()->role->role == 'guru')
                    {{ __('Isi Absensi Hari Ini') }}
                    @endif
                </h6>
            </div>
            <div class="card-body">
                <form method="get" action="{{route('absensi_siswa.index')}}" enctype="multipart/form-data">
                    <!-- @csrf -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control select-keterangan" name="jadwal">
                                    @foreach ($jadwalGuru as $jadwal)
                                    <option value="{{ $jadwal->id }}">{{ $jadwal->kelas->kelas }} {{ $jadwal->kelas->rombel }} -
                                        {{ $jadwal->mapel->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <a class="btn btn-light" href="{{url()->previous()}}" role="button">Kembali</a> -->
                            <button class="btn btn-success" type="submit"> Submit </button>
                        </div>
                    </div>
                </form>
                @if(request()->get('jadwal'))
                <form method="post" action="{{route('absensi_siswa.store')}}" enctype="multipart/form-data">
                    @csrf
                    <input name="id_jadwal" value="{{ $jadwalnya->id }}" hidden>
                    <input name="id_kelas" value="{{ $jadwalnya->id_kelas }}" hidden>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            @if($siswas != false)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Nama</th>
                                            <th>Hadir</th>
                                            <th>Sakit</th>
                                            <th>Izin</th>
                                            <th>Alpa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($siswas as $siswa)
                                        <tr class="text-center">
                                            <td>{{ $siswa->nama }}</td>
                                            <td><input class="" type="radio" name="{{ $siswa->id }}" value="1"></td>
                                            <td><input class="" type="radio" name="{{ $siswa->id }}" value="2"></td>
                                            <td><input class="" type="radio" name="{{ $siswa->id }}" value="3"></td>
                                            <td><input class="" type="radio" name="{{ $siswa->id }}" value="5"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-success float-right" type="submit"> Submit </button>
                            @else
                            Absensi kelas ini sudah terisi untuk hari ini.
                            @endif
                        </div>
                    </div>
                </form>
                @endif
                    <!-- <div class="col-md-5">
                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input class="form-control" name="title" placeholder="Masukkan Judul Berita">
                        </div>
                    </div> -->


                    
                </form>
            </div>
        </div>

    </section>
</div>
@endsection
@section('internalScript')
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script>
$(document).ready(function() {
    @if(!request()->get('jadwal'))
    $(".select-keterangan").val(null).trigger('change');
    @else
    $(".select-keterangan").val({{ request()->get('jadwal') }}).trigger('change');
    @endif
    $('.select-keterangan').select2({
        minimumResultsForSearch: Infinity,
        placeholder: 'Klik untuk memilih',
        theme: 'bootstrap4',
        width: 'style',
    });
});
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script> -->
@endsection