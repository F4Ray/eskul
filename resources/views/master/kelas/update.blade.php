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
                <h6 class="m-0 font-weight-bold text-primary">Edit Data Kelas</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('master_kelas.update', $kelas->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Kelas</label>
                                <input class="form-control" name="kode" value="{{ $kelas->kode }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelas</label>
                                <input class="form-control" name="kelas" value="{{ $kelas->kelas }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rombongan Belajar</label>
                                <input class="form-control" name="rombel" value="{{ $kelas->rombel }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Maksimal Jumlah Siswa</label>
                                <input class="form-control" name="max_jumlah" value="{{ $kelas->max_jumlah }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Wali Kelas</label>
                                <select class="form-control select-waliKelas" name="wali_kelas">
                                    @foreach ($gurus as $guru)
                                    <option value="{{$guru->id}}" @if($guru->id == $kelas->wali_kelas) {!!
                                        'selected="selected"' !!}
                                        @endif>{{ $guru->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <input class="form-control" name="tahun_ajaran" value="{{ $kelas->tahun_ajaran }}"
                                    readonly>
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
    <?php if ($kelas->wali_kelas == null) { ?>
    $(".select-waliKelas").val(null).trigger('change');
    <?php } ?>
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