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
        <div class="row">
            @if ($message = Session::get('success'))
            <div class="col-md-12">
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    {!! $message !!}
                </div>
            </div>
            @endif
        </div>
        <div class="row">
            @if ($message = Session::get('error'))
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    {!! $message !!}
                </div>
            </div>
            @endif
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
                <h6 class="m-0 font-weight-bold text-primary">Edit Data Guru</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('master_guru.ubahpassword', $guru->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        @if (Auth::user()->role->role == 'guru')
                        <div class="col-md-12">
                        @else
                        <div class="col-md-6">
                        @endif
                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control" name="username" value="{{ $user->username }}" readonly>
                                <small>Username tidak dapat diubah</small>
                            </div>
                        </div>
                        @if (Auth::user()->role->role == 'guru')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password Lama</label>
                                <input class="form-control" name="oldpassword">
                            </div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input class="form-control" name="newpassword">
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
@endsection