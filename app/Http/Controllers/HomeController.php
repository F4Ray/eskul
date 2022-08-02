<?php

namespace App\Http\Controllers;

use App\Models\AbsensiGuru;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\KeteranganAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('dashboard.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function guruHome()
    {
        if(auth()->user()->role->role != "guru"){
            return response()->json(['You do not have permission to access for this page.']);
        }
        $hari = Carbon::now()->isoFormat('dddd');
        $tanggalHariIni = Carbon::now()->toDateString();
        $absensi = AbsensiGuru::where('id_guru', Auth::user()->guru->id)->where('tanggal', $tanggalHariIni)->get();
        $keteranganAbsensi = KeteranganAbsensi::all();
        $keterangan = array();
        foreach ($keteranganAbsensi as $ket) {
            array_push($keterangan, $ket->keterangan);
        }
        $keteranganHadir = AbsensiGuru::where('id_guru', Auth::user()->guru->id)->where('id_keterangan_absensi',1)->get();
        $keteranganSakit = AbsensiGuru::where('id_guru', Auth::user()->guru->id)->where('id_keterangan_absensi',2)->get();
        $keteranganIzin = AbsensiGuru::where('id_guru', Auth::user()->guru->id)->where('id_keterangan_absensi',3)->get();
        $keteranganCuti = AbsensiGuru::where('id_guru', Auth::user()->guru->id)->where('id_keterangan_absensi',4)->get();
        $keteranganAlpa = AbsensiGuru::where('id_guru', Auth::user()->guru->id)->where('id_keterangan_absensi',5)->get();

        $detailKeterangan['hadir'] = $keteranganHadir->count();
        $detailKeterangan['sakit'] = $keteranganSakit->count();
        $detailKeterangan['izin'] = $keteranganIzin->count();
        $detailKeterangan['cuti'] = $keteranganCuti->count();
        $detailKeterangan['alpa'] = $keteranganAlpa->count();

        $detailKeterangan = (object) $detailKeterangan;

        if ($absensi->isEmpty()) {
            $cekAbsen = null;
        } else {
            $cekAbsen = 1;
        }
        $authUser = Auth::user();
        // var_dump($authUser->guru->id);
        $jadwalGuru = JadwalPelajaran::where('id_guru', $authUser->guru->id)->where('hari', $hari)->orderBy('jam_mulai', 'ASC')->get();

        // dd($jadwalGuru);
        return view('dashboard.guru', compact('jadwalGuru', 'cekAbsen', 'keterangan', 'detailKeterangan'));
    }
}
