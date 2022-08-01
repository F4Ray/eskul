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
            @if ($message = Session::get('success'))
            <div class="col-md-12">
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    {!! $message !!}
                </div>
            </div>
            @endif
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
                    {{ __('Edit Absensi Hari Ini') }}
                    @endif
                </h6>
            </div>
            <div class="card-body">
                
                <form method="post" action="{{route('absensi_siswa.update', $idJadwal)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mt-3">
                        <div class="col-md-12">
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
                                        @foreach($listAbsensi as $absensi)
                                        <tr class="text-center">
                                            <td>{{ $absensi->siswa->nama }}</td>
                                            <td><input class="" type="radio" name="{{ $absensi->id_siswa }}" value="1" @if($absensi->id_keterangan_absensi == 1) checked @endif></td>
                                            <td><input class="" type="radio" name="{{ $absensi->id_siswa }}" value="2" @if($absensi->id_keterangan_absensi == 2) checked @endif></td>
                                            <td><input class="" type="radio" name="{{ $absensi->id_siswa }}" value="3" @if($absensi->id_keterangan_absensi == 3) checked @endif></td>
                                            <td><input class="" type="radio" name="{{ $absensi->id_siswa }}" value="5" @if($absensi->id_keterangan_absensi == 5) checked @endif></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-success float-right" type="submit"> Submit </button>
                            
                        </div>
                    </div>
                </form>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script> -->
@endsection