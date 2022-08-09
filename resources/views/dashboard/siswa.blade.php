@extends('layouts.app')
@section('internalCSS')
<style>
    body {
        background-color: #f9f9fa
    }

    @media (min-width:992px) {
        .page-container {
            max-width: 1140px;
            margin: 0 auto
        }

        .page-sidenav {
            display: block !important
        }
    }

    .padding {
        padding: 2rem
    }

    .w-32 {
        width: 32px !important;
        height: 32px !important;
        font-size: .85em
    }

    .tl-item .avatar {
        z-index: 2
    }

    .circle {
        border-radius: 500px
    }

    .gd-warning {
        color: #fff;
        border: none;
        background: #f4c414 linear-gradient(45deg, #f4c414, #f45414)
    }

    .timeline {
        position: relative;
        /* border-color: rgba(160, 175, 185, .15); */
        padding: 0;
        margin: 0
    }

    .p-4 {
        padding: 1.5rem !important
    }

    .block,
    .card {
        background: #fff;
        border-width: 0;
        border-radius: .25rem;
        /* box-shadow: 0 1px 3px rgba(0, 0, 0, .05); */
        margin-bottom: 1.5rem
    }

    .mb-4,
    .my-4 {
        margin-bottom: 1.5rem !important
    }

    .tl-item {
        border-radius: 3px;
        position: relative;
        display: -ms-flexbox;
        display: flex
    }

    .tl-item>* {
        padding: 10px
    }

    .tl-item .avatar {
        z-index: 2
    }

    .tl-item:last-child .tl-dot:after {
        display: none
    }

    .tl-item.active .tl-dot:before {
        border-color: #448bff;
        box-shadow: 0 0 0 4px rgba(68, 139, 255, .2)
    }

    .tl-item:last-child .tl-dot:after {
        display: none
    }

    .tl-item.active .tl-dot:before {
        border-color: #448bff;
        box-shadow: 0 0 0 4px rgba(68, 139, 255, .2)
    }

    .tl-dot {
        position: relative;
        border-color: rgba(160, 175, 185, .15)
    }

    .tl-dot:after,
    .tl-dot:before {
        content: '';
        position: absolute;
        border-color: inherit;
        border-width: 2px;
        border-style: solid;
        border-radius: 50%;
        width: 10px;
        height: 10px;
        top: 15px;
        left: 50%;
        transform: translateX(-50%)
    }

    .tl-dot:after {
        width: 0;
        height: auto;
        top: 25px;
        bottom: -15px;
        border-right-width: 0;
        border-top-width: 0;
        border-bottom-width: 0;
        border-radius: 0
    }

    tl-item.active .tl-dot:before {
        border-color: #448bff;
        box-shadow: 0 0 0 4px rgba(68, 139, 255, .2)
    }

    .tl-dot {
        position: relative;
        border-color: rgba(160, 175, 185, .15)
    }

    .tl-dot:after,
    .tl-dot:before {
        content: '';
        position: absolute;
        border-color: inherit;
        border-width: 2px;
        border-style: solid;
        border-radius: 50%;
        width: 10px;
        height: 10px;
        top: 15px;
        left: 50%;
        transform: translateX(-50%)
    }

    .tl-dot:after {
        width: 0;
        height: auto;
        top: 25px;
        bottom: -15px;
        border-right-width: 0;
        border-top-width: 0;
        border-bottom-width: 0;
        border-radius: 0
    }

    .tl-content p:last-child {
        margin-bottom: 0
    }

    .tl-date {
        font-size: .85em;
        margin-top: 2px;
        min-width: 150px;
        max-width: 150px
    }

    .avatar {
        position: relative;
        line-height: 1;
        border-radius: 500px;
        white-space: nowrap;
        font-weight: 700;
        border-radius: 100%;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: center;
        justify-content: center;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        border-radius: 500px;
        box-shadow: 0 5px 10px 0 rgba(50, 50, 50, .15)
    }

    .b-warning {
        border-color: #f4c414 !important;
    }

    .b-primary {
        border-color: #448bff !important;
    }

    .b-danger {
        border-color: #f54394 !important;
    }
</style>
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
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
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Jadwal Pelajaran Anda</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="background-color: rgba(0, 0, 0, 0.04); color: #666;">Senin</th>
                                            @foreach($rosterSiswa->Senin as $rosterSenin)
                                            <td>{{ $rosterSenin->mapel->nama }} <br/>
                                               <div class="tl-date text-muted mt-1"> {{ $rosterSenin->jam_mulai }} - {{ $rosterSenin->jam_selesai }} </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(0, 0, 0, 0.04); color: #666;">Selasa</th>
                                            @foreach($rosterSiswa->Selasa as $rosterSenin)
                                            <td>{{ $rosterSenin->mapel->nama }} <br/>
                                               <div class="tl-date text-muted mt-1"> {{ $rosterSenin->jam_mulai }} - {{ $rosterSenin->jam_selesai }} </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(0, 0, 0, 0.04); color: #666;">Rabu</th>
                                            @foreach($rosterSiswa->Rabu as $rosterSenin)
                                            <td>{{ $rosterSenin->mapel->nama }} <br/>
                                               <div class="tl-date text-muted mt-1"> {{ $rosterSenin->jam_mulai }} - {{ $rosterSenin->jam_selesai }} </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(0, 0, 0, 0.04); color: #666;">Kamis</th>
                                            @foreach($rosterSiswa->Kamis as $rosterSenin)
                                            <td>{{ $rosterSenin->mapel->nama }} <br/>
                                               <div class="tl-date text-muted mt-1"> {{ $rosterSenin->jam_mulai }} - {{ $rosterSenin->jam_selesai }} </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(0, 0, 0, 0.04); color: #666;">Jumat</th>
                                            @foreach($rosterSiswa->Jumat as $rosterSenin)
                                            <td>{{ $rosterSenin->mapel->nama }} <br/>
                                               <div class="tl-date text-muted mt-1"> {{ $rosterSenin->jam_mulai }} - {{ $rosterSenin->jam_selesai }} </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(0, 0, 0, 0.04); color: #666;">Sabtu</th>
                                            @foreach($rosterSiswa->Sabtu as $rosterSenin)
                                            <td>{{ $rosterSenin->mapel->nama }} <br/>
                                               <div class="tl-date text-muted mt-1"> {{ $rosterSenin->jam_mulai }} - {{ $rosterSenin->jam_selesai }} </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Absen Anda Bulan ini</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <canvas id="pieChart" style="max-width: 500px;"></canvas>
                        </div>
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
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Mata Pelajaran Hari ini</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="timeline p-4 block mb-4">
                                    @foreach($jadwalSiswa as $jadwal)
                                    <div class="tl-item">
                                        <div class="tl-dot b-primary"></div>
                                        <div class="tl-content">
                                            <div class=""> {{ $jadwal->mapel->nama }}
                                            </div>
                                            <div class="tl-date text-muted mt-1">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
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

        </div>
</div>

</section>
</div>
@endsection
@section('internalScript')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.2/dist/chart.min.js"> </script>
<script>
    //pie
    var ctxP = document.getElementById("pieChart").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        type: 'pie',
        data: {
            labels: @json($keterangan),
            datasets: [{
                data: [{{ $detailKeterangan->hadir }}, {{ $detailKeterangan->sakit }}, {{ $detailKeterangan->izin }}, {{ $detailKeterangan->alpa }}],
                backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#4D5360"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#616774"]
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

@endsection