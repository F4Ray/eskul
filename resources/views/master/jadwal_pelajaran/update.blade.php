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
            <h1>Master Data</h1>
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
                <h6 class="m-0 font-weight-bold text-primary">Tambah Data Jadwal Pelajaran</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('master_jadwal_pelajaran.update', $jadwal->id)}}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelas</label>
                                <input class="form-control" name="id_kelas"
                                    value="{{ $jadwal->kelas->kelas }} {{ $jadwal->kelas->rombel }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <select class="form-control select-mapel" name="id_mata_pelajaran">
                                    <option value="{{ $jadwal->id_mata_pelajaran }}" class="hide_this" selected>
                                        {{ $jadwal->mapel->nama }}
                                    </option>
                                    @foreach ($mapelnya as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->nama }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Guru</label>
                                @if($gurunya == null)
                                {!! Form::select('id_guru',[''=>'Pilih mata pelajaran terlebih
                                dahulu'],null,['class'=>'form-control select-guru'])
                                !!}
                                @else
                                <select class="form-control select-guru" name="id_guru">
                                    <option value="{{ $jadwal->id_guru }}" class="select2-selected" selected>
                                        {{ $jadwal->guru->nama }}
                                    </option>
                                    @foreach ($gurunya as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama }} </option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Semester</label>
                                <input class="form-control" name="semester" value="{{ $jadwal->semester }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hari</label>
                                <input class="form-control" name="hari" value="{{ $jadwal->hari }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jam Mulai</label>
                                <input class="form-control" name="jam_mulai"
                                    value="{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jam Selesai</label>
                                <input class="form-control" name="jam_selesai"
                                    value="{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <input class="form-control" name="tahun_ajaran" value="{{ $jadwal->tahun_ajaran }}"
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


                    <a class="btn btn-light" href="{{route('master_jadwal_pelajaran.index')}}" role="button">Kembali</a>
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