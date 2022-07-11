@extends('layouts.app')
@section('internalCSS')
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
            <h1>Master Data</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Guru</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('master_kelas.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Kelas</label>
                                <input class="form-control" name="kode" value="{{ $jadiKode }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control select-kelas" name="kelas" placeholder="Pilih Kelas">
                                    <option value="VII">7</option>
                                    <option value="VIII">8</option>
                                    <option value="IX">9</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rombongan Belajar</label>
                                <input class="form-control" name="rombel" placeholder="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Maksimal Jumlah Siswa</label>
                                <input class="form-control" name="max_jumlah" placeholder="35">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Wali Kelas</label>
                                <select class="form-control select-waliKelas" name="wali_kelas">
                                    @foreach ($gurus as $guru)
                                    <option value="{{$guru->id}}">{{ $guru->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <input class="form-control" name="tahun_ajaran" placeholder="2021/2022">
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
                    <button class="btn btn-success ml-1" type="submit"> Submit </button>
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
    $(".select-waliKelas").val(null).trigger('change');
    $(".select-kelas").val(null).trigger('change');
    $('.select-waliKelas').select2({
        placeholder: "Pilih Wali Kelas",
        theme: 'bootstrap4',
        width: 'style',
    });
    $('.select-kelas').select2({
        minimumResultsForSearch: Infinity,
        placeholder: "Pilih Kelas",
        theme: 'bootstrap4',
        width: 'style',
    });
});
</script>
@endsection