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
            <h1>Master Data</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Edit Data Siswa</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('master_siswa.update', $siswa->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input class="form-control" name="nama" value="{{$siswa->nama }}">
                                @error('nama')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIS</label>
                                <input class="form-control" name="nis" value="{{$siswa->nis }}" readonly>
                                <small>NIS sebagai username tidak dapat diubah</small>
                                @error('nis')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NISN</label>
                                <input class="form-control" name="nisn" value="{{$siswa->nisn }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input class="form-control" name="tempat_lahir" @if($siswa->tempat_lahir != null)
                                value="{{ $siswa->tempat_lahir }}" @else placeholder="Medan" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type='date' name='tanggal_lahir' class='form-control' @if($siswa->tanggal_lahir
                                != null)
                                value="{{ $siswa->tanggal_lahir }}" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="form-control select-jeniskel" name="jenis_kelamin">
                                    <option value="Laki-Laki" @if($siswa->jenis_kelamin == 'Laki-Laki')
                                        selected="selected" @endif>Laki Laki</option>
                                    <option value="Perempuan" @if($siswa->jenis_kelamin == 'Perempuan')
                                        selected="selected" @endif>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Agama</label>
                                <input class="form-control" name="agama" @if($siswa->agama != null)
                                value="{{ $siswa->agama }}" @else placeholder="Islam" @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Alamat Lengkap</label>
                                <textarea class=" form-control"
                                    @if($siswa->alamat == null)  placeholder="Jalan ..." @endif name="alamat">@if($siswa->alamat != null){{ $siswa->alamat }} @endif</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Telpon/HP</label>
                                <input class="form-control" name="no_hp" @if($siswa->no_hp != null)
                                value="{{ $siswa->no_hp }}" @else placeholder="08..." @endif>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>kelas</label>
                                @if($siswa->id_kelas != null)
                                <select class="form-control select-kelas" readonly>
                                    <option > {{$siswa->kelas->kelas}} {{ $siswa->kelas->rombel }} </option>
                                </select>
                                <small class="text-danger" >Kelas tidak dapat diubah</small>
                                @else
                                <select class="form-control select-kelas" name="kelas">
                                    @foreach ($kelases as $kelas)
                                    <option value="{{ $kelas->id }}" @if($kelas->id == $siswa->id_kelas)
                                        selected= "selected" @endif>{{ $kelas->kelas }} {{$kelas->nama }}
                                        {{ $kelas->rombel }}
                                    </option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" name="email" @if($siswa->email
                                != null)
                                value="{{ $siswa->email }}" @else placeholder="...@gmail.com" @endif>
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
    <?php if ($siswa->jenis_kelamin == null) { ?>
    $(".select-jeniskel").val(null).trigger('change');
    <?php } ?>
    <?php if ($siswa->id_kelas == null) { ?>
    $(".select-kelas").val(null).trigger('change');
    <?php } ?>
    $('.select-kelas').select2({
        val: '',
        placeholder: "Pilih Kelas",
        theme: 'bootstrap4',
        width: 'style',
    });
    $('.select-jeniskel').select2({
        minimumResultsForSearch: Infinity,
        val: '',
        placeholder: "Pilih Jenis Kelamin",
        theme: 'bootstrap4',
        width: 'style',
    });
});
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script> -->
@endsection