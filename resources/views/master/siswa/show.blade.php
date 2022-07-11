@extends('layouts.app')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Master Data</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Tambah Data Guru</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-3 text-center">
                        <img src="{{ asset('assets/img/avatar/avatar-4.png') }}" class="ml-auto img-fluid"
                            height="157.3" width="140">
                        <a class="btn btn-primary mt-1" href="{{route('master_siswa.edit', $siswa->id)}}"
                            role="button">Edit
                            Gambar</a>
                    </div>
                    <div class="col-md-10 ">
                        <div class="row">
                            <div class="col-md-6 float-md-left float-lg-left">
                                <p>Nama Lengkap : {{ $siswa->nama }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>NIP : {{ $siswa->nis }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Kelas: {{ $siswa->kelas->kelas }} {{$siswa->kelas->rombel}} </p>
                            </div>
                            <div class="col-md-6">
                                <p>Jenis Kelamin : {{ $siswa->jenis_kelamin }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Tempat, Tanggal Lahir : {{$siswa->tempat_lahir}}, {{ $siswa->tempat_lahir }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Agama : {{$siswa->agama}}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Alamat : {{$siswa->alamat}}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Nomor Telpon/HP : {{$siswa->no_hp}}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Email : {{$siswa->email}}</p>
                            </div>
                        </div>
                    </div>

                </div>
                <a class="btn btn-light" href="{{route('master_siswa.index')}}" role="button">Kembali</a>
                <a class="btn btn-primary ml-2" href="{{route('master_siswa.edit', $siswa->id)}}" role="button">Edit
                    Data</a>
            </div>
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