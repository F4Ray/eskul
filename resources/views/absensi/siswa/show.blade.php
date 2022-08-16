@extends('layouts.app')
@section('internalCSS')
<!-- <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
    integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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
            <h1>Nilai Siswa</h1>
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
                    Absensi Siswa
                </h6>
            </div>
            <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table-nilai">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Mata Pelajaran</th>
                                            @foreach ($dates as $date)
                                            <th> {{ $date }} </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($newAr as $key => $value)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            @foreach ($dates as $date)
                                            <td> {{ $value[$date] ?? "-"}} </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

    </section>
</div>
@endsection
@section('internalScript')
<script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
<script>
$(document).ready(function() {
    load_datas();

    function load_data() {
        $('#table-nilai').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("master_siswa.lihatabsen" , $id) }}',
                data: {
                    siswa: '{{ $id }}',
                },
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
            ]
        });
    }

    $(".select-siswa").val({{ request()->get('siswa') }}).trigger('change');
    $(".select-jadwal").val({{ request()->get('jadwal') }}).trigger('change');

    $('.select-siswa').select2({
        placeholder: 'Klik untuk memilih',
        theme: 'bootstrap4',
        width: 'style',
    });
    $('.select-jadwal').select2({
        placeholder: 'Klik untuk memilih',
        theme: 'bootstrap4',
        width: 'style',
    });
    setTimeout(function() {
        $("select[name='siswa']").change(function() {
            console.log("halo");
            var id_siswa = $(this).val();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "<?php echo route('nilai.ajax_kelas') ?>",
                method: 'POST',
                data: {
                    id_siswa: id_siswa,
                    _token: token
                },
                success: function(data) {
                    $("select[name='jadwal'").attr("data-placeholder", "Pilih mata pelajaran");
                    // $("select[name='jadwal'").val(null).trigger('change');
                    $("select[name='jadwal'").html(data.options);
                }
            });
        });
    }, 2000);
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