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

.hide_this {
    display: none !important;
}

.select2-results__option[aria-selected=true] {
    display: none !important;
}
</style>
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Nilai Siswa</h1>
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
                <h6 class="m-0 font-weight-bold text-primary">Tambah Nilai Siswa</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('nilai.update', $nilai->id)}}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input class="form-control"
                                    value="{{ $nilai->siswa->nama }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelas</label>
                                <input class="form-control"
                                    value="{{ $nilai->jadwal->kelas->kelas }} {{ $nilai->jadwal->kelas->rombel }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <input class="form-control"
                                    value="{{ $nilai->jadwal->mapel->nama }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Guru Pengampu</label>
                                <input class="form-control"
                                    value="{{ $nilai->jadwal->guru->nama }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nilai KKM</label>
                                <input class="form-control" name="nilai_kkm"
                                    value="{{ $nilai->jadwal->mapel->kkm }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nilai Tugas</label>
                                @if (Auth::user()->role->role == 'guru' AND $nilai->nilai_tugas != null)
                                <input class="form-control" name="nilai_tugas"
                                    value="{{ $nilai->nilai_tugas }}" readonly>
                                @else
                                <input class="form-control" name="nilai_tugas"
                                    value="{{ $nilai->nilai_tugas }}">
                                @endif
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nilai UTS</label>
                                @if (Auth::user()->role->role == 'guru' AND $nilai->nilai_uts != null)
                                <input class="form-control" name="nilai_uts"
                                    value="{{ $nilai->nilai_uts }}" readonly>
                                @else
                                <input class="form-control" name="nilai_uts"
                                    value="{{ $nilai->nilai_uts }}">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nilai UAS</label>
                                @if (Auth::user()->role->role == 'guru' AND $nilai->nilai_uas != null)
                                <input class="form-control" name="nilai_uas"
                                    value="{{ $nilai->nilai_uas }}" readonly>
                                @else
                                <input class="form-control" name="nilai_uas"
                                    value="{{ $nilai->nilai_uas }}">
                                @endif
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
    $('.select-mapel').select2({
        theme: 'bootstrap4',
        width: 'style',
    });
    $('.select-guru').select2({
        theme: 'bootstrap4',
        width: 'style',
    });
});
$("select[name='id_mata_pelajaran']").change(function() {
    var id_mata_pelajaran = $(this).val();
    var token = $("input[name='_token']").val();
    $.ajax({
        url: "<?php echo route('master_jadwal_pelajaran.ajax_guru') ?>",
        method: 'POST',
        data: {
            id_mata_pelajaran: id_mata_pelajaran,
            _token: token
        },
        success: function(data) {
            $("select[name='id_guru'").val(null).trigger('change');
            $("select[name='id_guru'").html(data.options);
        }
    });
});
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script> -->
@endsection