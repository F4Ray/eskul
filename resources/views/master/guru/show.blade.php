@extends('layouts.app')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Master Data</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Data Guru</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-3 text-center">
                        <img src="{{ asset('assets/img/avatar/avatar-4.png') }}" class="ml-auto img-fluid"
                            height="157.3" width="140">
                        <a class="btn btn-primary mt-1" href="{{route('master_guru.update', $guru->id)}}"
                            role="button">Edit
                            Gambar</a>
                    </div>
                    <div class="col-md-10 ">
                        <div class="row">
                            <div class="col-md-6 float-md-left float-lg-left">
                                <p>Nama Lengkap : {{ $guru->nama }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>NIP : {{ $guru->nip }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Jenis Kelamin : {{ $guru->jenis_kelamin }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Tempat, Tanggal Lahir : {{$guru->tempat_lahir}}, {{ $guru->tempat_lahir }}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Agama : {{$guru->agama}}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Alamat : {{$guru->alamat}}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Nomor Telpon/HP : {{$guru->no_hp}}</p>
                            </div>
                            <div class="col-md-6">
                                <p>Email : {{$guru->email}}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="row">
                                    <div class="col-md-4" style="margin-right: 0px;padding-right:0px">Mata Pelajaran :
                                    </div>
                                    <div class="col-md-8" style="padding-left: 0px;">
                                        @foreach($guru->mapel as $mapel)
                                        <li class="mt-0"> {{$mapel->kelas }} {{$mapel->nama}} </li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <a class="btn btn-light" href="{{route('master_guru.index')}}" role="button">Kembali</a>
                <a class="btn btn-primary ml-2" href="{{route('master_guru.update', $guru->id)}}" role="button">Edit
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