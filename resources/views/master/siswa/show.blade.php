@extends('layouts.app')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Master Data</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-3 text-center">
                        <img src="{{ asset('storage/assets/img/avatar/'.$siswa->foto) }}" class="ml-auto img-fluid"
                            height="157.3" width="140">
                        <a class="btn btn-primary mt-1" href="{{route('master_siswa.gantifoto', $siswa->id)}}"
                            role="button">Edit
                            Gambar</a>
                    </div>
                    <div class="col-md-10 ">
                        <div class="row">
                            <div class="col-md-6 float-md-left float-lg-left">
                                <p>Nama Lengkap : {{ $siswa->nama }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>NIS : {{ $siswa->nis }}</p>
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
                @if(Auth::check() && Auth::user()->id_role == 1)
                <a class="btn btn-light" href="{{url()->previous()}}" role="button">Kembali</a>
                @endif
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