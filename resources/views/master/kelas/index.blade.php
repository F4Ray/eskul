    @extends('layouts.app')

    @section('internalCSS')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">

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
                        {{ $message }}
                    </div>
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Kelas</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <a name="" id="" class="btn btn-primary d-block"
                                        href="{{ route('master_kelas.create') }}" role="button">Tambah Data</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" id="table-mapel">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Kode</th>
                                            <th scope="col">Kelas</th>
                                            <th scope="col">Wali Kelas</th>
                                            <th scope="col">Jumlah Siswa Maksimal</th>
                                            <th scope="col">Tahun Ajaran</th>
                                            <th scope="col">Detail</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
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
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
    <script type="text/javascript">
$(document).ready(function() {
    load_data();

    function load_data() {
        $('#table-mapel').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("master_kelas.index") }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'kelas',
                    name: 'kelas'
                },
                {
                    data: 'walikelas',
                    name: 'walikelas'
                },
                {
                    data: 'max_jumlah',
                    name: 'max_jumlah'
                },
                {
                    data: 'tahun_ajaran',
                    name: 'tahun_ajaran'
                },
                {
                    data: 'detail',
                    name: 'detail',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: false
                },
            ]
        });
    }
});
let tablenya = $('#table-mapel');
tablenya.on('click', '.show_confirm', function(e) {
    var form = $(this).closest("form");
    var name = $(this).data("name");
    event.preventDefault();
    Swal.fire({
        title: 'Hapus data',
        text: "Yakin mau dihapus?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: "Batal",
        confirmButtonText: 'Hapus'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    })
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
    @endsection