@extends('layouts.app')
@section('internalCSS')
<!-- <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
    integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap4.css') }}" />
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
                <form method="post" action="{{route('master_mapel.update', $mapel->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Mata Pelajaran</label>
                                <input class="form-control" name="kode" value="{{ $mapel->kode }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Mata Pelajaran</label>
                                <input class="form-control" name="nama" value="{{ $mapel->nama }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control" name="kelas">
                                    <option value="{{ $mapel->kelas }}" hidden>{{ $mapel->kelas }}</option>
                                    <option value="VII">VII</option>
                                    <option value="VIII">VIII</option>
                                    <option value="IX">IX</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>KKM</label>
                                <input class="form-control" name="kkm" value="{{ $mapel->kkm }}">
                            </div>
                        </div>


                    </div>
                    <!-- <div class="col-md-5">
                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input class="form-control" name="title" placeholder="Masukkan Judul Berita">
                        </div>
                    </div> -->


                    <a class="btn btn-light" href="{{route('master_mapel.index')}}" role="button">Kembali</a>
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
    $('.select-matkul').select2({
        theme: 'bootstrap4',
        width: 'style',
    });
});
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script> -->
@endsection