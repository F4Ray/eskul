@extends('layouts.app')
@section('internalCSS')
<!-- <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
    integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap4.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
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
            <h1>Absensi Siswa</h1>
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
                    <!-- @if (Auth::user()->role->role == 'admin')
                    {{ __('Lihat Absensi Siswa') }}
                    @else (Auth::user()->role->role == 'guru')
                    {{ __('Isi Absensi Hari Ini') }}
                    @endif -->
                    Lihat Absensi Siswa
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
                        <div class="col-md-4">
                        <div class="form-group">
                                <label>Tanggal</label>
                                @if(!request()->get('tanggal'))
                                <input type='date' name='tanggal' max="{{ \Carbon\Carbon::now()->format('Y-m-d'); }}" class='form-control'>
                                @else
                                <input type='date' name='tanggal' value="{{ request()->get('tanggal') }}" class='form-control' max="{{ \Carbon\Carbon::now()->format('Y-m-d'); }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <a class="btn btn-light" href="{{url()->previous()}}" role="button">Kembali</a> -->
                            <button class="btn btn-primary" type="submit"> Submit </button>
                        </div>
                    </div>
                </form>
                @if(request()->get('jadwal'))
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Nama</th>
                                            <th>Diabsen oleh</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($absens->isEmpty())
                                        <tr>
                                            <td colspan="5">Tidak ada data absen. <a href="{{ route('absensi_siswa.create', ['jadwal'=> request()->get('jadwal') , 'tanggal' => request()->get('tanggal')] ) }}" target="">Klik disini</a> untuk mengisi absen</td>
                                        </tr>
                                        @else
                                        @foreach($absens as $absen)
                                        <tr class="text-center">
                                            <td>{{ $absen->siswa->nama }}</td>
                                            <td>@if($absen->id_guru == 9999) Admin @else {{ $absen->guru->nama }} @endif</td>
                                            <td>{{ $absen->keterangan->keterangan }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Absensi kelas ini sudah terisi untuk hari ini. <a href="#">Klik disini</a> untuk mengubah absensi siswa. -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 float-right">
                            @if($absens->isNotEmpty())
                            @if (Auth::user()->role->role == 'admin')
                                <!-- <a class="btn btn-danger float-right " href=""> Hapus Data </a> -->

                                <form action="{{ route('absensi_siswa.destroy', ['id'=>request()->get('jadwal'), 'date'=> request()->get('tanggal')]) }}" method="post" id="formHapus">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger float-right show_confirm " data-toggle="tooltip" name="delete"> Hapus </button>
                                </form>
                                
                                <a class="btn btn-success float-right mr-2" href="{{route('absensi_siswa.edit', ['id'=> $jadwalnya->id, 'date'=> request()->get('tanggal') ] )}}" role="button"> Edit Data </a>
                            @else
                            @if(request()->get('tanggal') == \Carbon\Carbon::now()->format('Y-m-d'))
                                <a class="btn btn-success float-right" href="{{route('absensi_siswa.edit', ['id'=> $jadwalnya->id, 'date'=> \Carbon\Carbon::now()->format('Y-m-d') ])}}" role="button"> Edit Data </a>
                            @endif
                            @endif
                            @endif
                        </div>
                    </div>
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
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
<script>
$(document).ready(function() {
    @if(!request()->get('jadwal'))
    $(".select-keterangan").val(null).trigger('change');
    @else
    $(".select-keterangan").val({{ request()->get('jadwal') }}).trigger('change');
    @endif
    $('.select-keterangan').select2({
        placeholder: 'Klik untuk memilih',
        theme: 'bootstrap4',
        width: 'style',
    });
});

let tablenya = $('.show_confirm');
tablenya.on('click', function(e) {
    // var form = ($(this).parents('form'));
    var form = $(this).closest("form");
    // var form = $('#formHapus');
    // var name = $(this).data("name");
    event.preventDefault();
    Swal.fire({
        title: 'Hapus data',
        text: "Yakin mau dihapus?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: "Batal",
        confirmButtonText: 'Hapus'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    })
});
<?php if (session()->has('successHapus')) { ?>
Swal.fire({
    type: "success",
    icon: "success",
    title: "BERHASIL!",
    text: "{{ session('successHapus') }}",
    timer: 1500,
    showConfirmButton: false,
    showCancelButton: false,
    buttons: false,
});
<?php } elseif (session()->has('error')) { ?>
Swal.fire({
    type: "error",
    icon: "error",
    title: "GAGAL!",
    text: "{{ session('error') }}",
    timer: 1500,
    showConfirmButton: false,
    showCancelButton: false,
    buttons: false,
});
<?php } ?>
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script> -->
@endsection