@extends('layouts.app')
@section('internalCSS')
<!-- <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
    integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap4.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
<style>
.select2-selection__rendered {
    margin: 4.5px;
}
input[type="radio"]{
   appearance: none;
   border: 1px solid #d3d3d3;
   width: 30px;
   height: 30px;
   content: none;
   outline: none;
   margin: 0;
   box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}

input[type="radio"]:checked {
  appearance: none;
  outline: none;
  padding: 0;
  content: none;
  border: none;
}

input[type="radio"]:checked::before{
  /* position: absolute; */
  color: green !important;
  content: "\00A0\2713\00A0" !important;
  border: 1px solid #d3d3d3;
  font-weight: bolder;
  font-size: 21px;
}
</style>
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Absensi Siswa</h1>
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
                <h6 class="m-0 font-weight-bold text-primary">
                    <!-- @if (Auth::user()->role->role == 'admin')
                    {{ __('Lihat Absensi Siswa') }}
                    @else (Auth::user()->role->role == 'guru')
                    {{ __('Isi Absensi Hari Ini') }}
                    @endif -->
                    Lihat Absensi Siswa
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{route('nilai.lihat')}}" enctype="multipart/form-data">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                    <label>Kelas</label>
                                    <select class="form-control select-kelas" name="kelas">
                                        @foreach ($kelases as $kelas)
                                        <option value="{{ $kelas->id }}">{{ $kelas->kelas }} {{ $kelas->rombel }}
                                        </option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Pilih Matkul</label>
                                {!! Form::select('jadwal',[''=>'Pilih kelas terlebih
                                dahulu'],null,['class'=>'form-control select-jadwal'])
                                !!}
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <a class="btn btn-light" href="{{url()->previous()}}" role="button">Kembali</a> -->
                            <button class="btn btn-primary" type="submit"> Submit </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>
</div>
@endsection
@section('internalScript')
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
<script>
$(document).ready(function() {
    
    $(".select-kelas").val(null).trigger('change');
    $('.select-kelas').select2({
        placeholder: 'Klik untuk memilih',
        theme: 'bootstrap4',
        width: 'style',
    });

    $('.select-jadwal').select2({
        placeholder: 'Pilih kelas terlebih dahulu',
        theme: 'bootstrap4',
        width: 'style',
    });
});

$("select[name='kelas']").change(function() {
    console.log("halo");
    var id_kelas = $(this).val();
    var token = $("input[name='_token']").val();
    $.ajax({
        url: "<?php echo route('nilai.ajax_kelas') ?>",
        method: 'POST',
        data: {
            id_kelas: id_kelas,
            _token: token
        },
        success: function(data) {
            $("select[name='jadwal'").attr("data-placeholder", "Pilih mata pelajaran");
            // $("select[name='jadwal'").val(null).trigger('change');
            $("select[name='jadwal'").html(data.options);
        }
    });
});



<?php if (session()->has('successHapus')) { ?>
Swal.fire({
    type: "success",
    icon: "success",
    title: "BERHASIL!",
    text: "{{ session('successHapus') }}",
    timer: 1500,
    showConfirmButton: false,
    showCancelButton: false,
    buttons: false,
});
<?php } elseif (session()->has('error')) { ?>
Swal.fire({
    type: "error",
    icon: "error",
    title: "GAGAL!",
    text: "{{ session('error') }}",
    timer: 1500,
    showConfirmButton: false,
    showCancelButton: false,
    buttons: false,
});
<?php } ?>
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script> -->
@endsection