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
                <h6 class="m-0 font-weight-bold text-primary">Edit Data Guru</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('master_guru.update', $guru->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Guru</label>
                                <input class="form-control" name="nama" value="{{ $guru->nama }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIP</label>
                                <input class="form-control" name="nip" value="{{ $guru->nip }}" readonly>
                                <small>NIP tidak dapat diubah</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input class="form-control" name="tempat_lahir" value="{{ $guru->tempat_lahir }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type='date' name='tanggal_lahir' class='form-control'
                                    value="{{ $guru->tanggal_lahir }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelamin">
                                    <option value="{{ $guru->jenis_kelamin }}" hidden>{{ $guru->jenis_kelamin }}
                                    </option>
                                    <option value="Laki-Laki">Laki Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Agama</label>
                                <input class="form-control" name="agama" placeholder="Islam" value="{{ $guru->agama }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Alamat Lengkap</label>
                                <textarea class=" form-control" placeholder="Jalan ..."
                                    name="alamat">{{ $guru->alamat }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Telpon/HP</label>
                                <input class="form-control" name="no_hp" value="{{ $guru->no_hp }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mata Pelajaran</label>
                                <select class="form-control select-mapel" name="id_mata_pelajaran">
                                    @if($guru->id_mata_pelajaran != null)
                                    <option value="{{ $guru->id_mata_pelajaran }}" hidden>{{$guru->mapel->kelas}}
                                        {{ $guru->mapel->nama }}
                                    </option>
                                    @else
                                    <option hidden>Pilih Mata Pelajaran
                                    </option>
                                    @endif
                                    @foreach ($mapels as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->kelas }} {{$mapel->nama }}</option>
                                    @endforeach
                                </select>
                                <small>Jika tidak ada mata pelajaran yang sesuai, tambah mata pelajaran <a
                                        href="{{ route('master_mapel.create') }}">disini</a></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" name="email" value="{{ $guru->email }}">
                            </div>
                        </div>

                    </div>
                    <!-- <div class="col-md-5">
                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input class="form-control" name="title" placeholder="Masukkan Judul Berita">
                        </div>
                    </div> -->


                    <a class="btn btn-light" href="{{route('master_guru.index')}}" role="button">Kembali</a>
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
});
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script> -->
@endsection