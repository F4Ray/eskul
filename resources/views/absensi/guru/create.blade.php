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
                    {{ __('Tambah Absensi Guru') }}
                    @else (Auth::user()->role->role == 'guru')
                    {{ __('Isi Absensi Hari Ini') }}
                    @endif
                </h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('absensi_guru.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Guru</label>
                                @if (Auth::user()->role->role == 'admin')
                                <select class="form-control select-guru" name="guru">
                                    @foreach ($guru as $gurunya)
                                    <option value="{{ $gurunya->id }}">{{ $gurunya->nama }}</option>
                                    @endforeach
                                </select>
                                @else (Auth::user()->role->role == 'guru')
                                <input class="form-control" name="nama" value="{{ $guru->nama }}" readonly>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal</label>
                                @if (Auth::user()->role->role == 'admin')
                                <input type='date' name='tanggal' class='form-control' max="{{ $tanggalHariIni }}">
                                @else (Auth::user()->role->role == 'guru')
                                <input type='date' name='tanggal' class='form-control' value="{{ $tanggalHariIni }}" readonly>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <select class="form-control select-keterangan" name="keterangan">
                                    @foreach ($keterangans as $keterangan)
                                    <option value="{{ $keterangan->id }}">{{ $keterangan->keterangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- <div class="col-md-5">
                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input class="form-control" name="title" placeholder="Masukkan Judul Berita">
                        </div>
                    </div> -->


                    <a class="btn btn-light" href="{{url()->previous()}}" role="button">Kembali</a>
                    <button class="btn btn-success" type="submit"> Submit </button>
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
        $(".select-guru").val(null).trigger('change');
        $('.select-keterangan').select2({
            minimumResultsForSearch: Infinity,
            placeholder: 'Klik untuk memilih',
            theme: 'bootstrap4',
            width: 'style',
        });
        $('.select-guru').select2({
            placeholder: 'Klik untuk memilih',
            theme: 'bootstrap4',
            width: 'style',
        });
    });
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script> -->
@endsection