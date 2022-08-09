<?php

namespace App\Http\Controllers;

use App\Models\AbsensiGuru;
use App\Models\AbsensiSiswa;
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
        if(auth()->user()->role->role != "siswa"){
            return response()->json(['You do not have permission to access for this page.']);
        }
        $hari = Carbon::now()->isoFormat('dddd');
        $tanggalHariIni = Carbon::now()->toDateString();
        $authUser = Auth::user();
        $jadwalSiswa = JadwalPelajaran::where('id_kelas', $authUser->siswa->id_kelas)->where('hari', $hari)->orderBy('jam_mulai', 'ASC')->get();
        $rosterSiswa['Senin'] = $rosterSiswaSenin = JadwalPelajaran::where('id_kelas', $authUser->siswa->id_kelas)->orderBy('jam_mulai', 'ASC')->where('hari', "Senin")->get();
        $rosterSiswa['Selasa'] = $rosterSiswaSelasa = JadwalPelajaran::where('id_kelas', $authUser->siswa->id_kelas)->orderBy('jam_mulai', 'ASC')->where('hari', "Selasa")->get();
        $rosterSiswa['Rabu'] = $rosterSiswaRabu = JadwalPelajaran::where('id_kelas', $authUser->siswa->id_kelas)->orderBy('jam_mulai', 'ASC')->where('hari', "Rabu")->get();
        $rosterSiswa['Kamis'] = $rosterSiswaKamis = JadwalPelajaran::where('id_kelas', $authUser->siswa->id_kelas)->orderBy('jam_mulai', 'ASC')->where('hari', "Kamis")->get();
        $rosterSiswa['Jumat'] = $rosterSiswaJumat = JadwalPelajaran::where('id_kelas', $authUser->siswa->id_kelas)->orderBy('jam_mulai', 'ASC')->where('hari', "Jumat")->get();
        $rosterSiswa['Sabtu'] = $rosterSiswaSabtu = JadwalPelajaran::where('id_kelas', $authUser->siswa->id_kelas)->orderBy('jam_mulai', 'ASC')->where('hari', "Sabtu")->get();

        $rosterSiswa = (object) $rosterSiswa;


        $keteranganAbsensi = KeteranganAbsensi::all();
        $keterangan = array();
        foreach ($keteranganAbsensi as $ket) {
            array_push($keterangan, $ket->keterangan);
        }
        $keteranganHadir = AbsensiSiswa::where('id_siswa', Auth::user()->siswa->id)->where('id_keterangan_absensi',1)->get();
        $keteranganSakit = AbsensiSiswa::where('id_siswa', Auth::user()->siswa->id)->where('id_keterangan_absensi',2)->get();
        $keteranganIzin = AbsensiSiswa::where('id_siswa', Auth::user()->siswa->id)->where('id_keterangan_absensi',3)->get();
        $keteranganAlpa = AbsensiSiswa::where('id_siswa', Auth::user()->siswa->id)->where('id_keterangan_absensi',5)->get();

        $detailKeterangan['hadir'] = $keteranganHadir->count();
        $detailKeterangan['sakit'] = $keteranganSakit->count();
        $detailKeterangan['izin'] = $keteranganIzin->count();
        $detailKeterangan['alpa'] = $keteranganAlpa->count();

        $detailKeterangan = (object) $detailKeterangan;
        return view('dashboard.siswa', compact('jadwalSiswa','keterangan','detailKeterangan','rosterSiswa'));
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
