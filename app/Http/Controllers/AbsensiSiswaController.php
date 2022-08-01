<?php

namespace App\Http\Controllers;

use App\Models\AbsensiSiswa;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        // $hari = Carbon::now()->isoFormat('dddd');
        $hari = 'Senin';
        $jadwalGuru = JadwalPelajaran::where('id_guru', Auth::user()->guru->id)->where('hari', $hari)->get();
        if ($request->get('jadwal')) {
            $jadwalnya = JadwalPelajaran::findOrFail($request->jadwal);
            if ($this->cekAbsen($request->jadwal) === false) {
                $siswas = Siswa::where('id_kelas', $jadwalnya->kelas->id)->get();
            }else{
                $siswas = false;
            }
            return view('absensi.siswa.index', compact('jadwalGuru', 'siswas','jadwalnya'));
        }
        return view('absensi.siswa.index', compact('jadwalGuru'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jadwalnya = JadwalPelajaran::findOrFail($request->id_jadwal);
        $siswas = Siswa::where('id_kelas', $jadwalnya->kelas->id)->get();
        // foreach ($siswas as $siswa) {
        //     var_dump($siswa->id);
        //     var_dump($request[$siswa->id]);
        // }
        // dd($request->all());

        foreach ($siswas as $siswa) {
            $absensiSiswa = new AbsensiSiswa;
            $absensiSiswa->id_siswa = $siswa->id;
           if (Auth::user()->role->role === 'guru') 
           {
            $absensiSiswa->id_guru = Auth::user()->guru->id;
           }else
           {
            $absensiSiswa->id_guru = 9999;
           }
            $absensiSiswa->id_jadwal = $request->id_jadwal;
            $absensiSiswa->tanggal = Carbon::now()->format('Y-m-d');
            $absensiSiswa->tahun_ajaran = '2022/2023';
            $absensiSiswa->id_keterangan_absensi = $request[$siswa->id];
            $absensiSiswa->save();
        }
        return redirect()->route('absensi_siswa.index')
        ->with('success', 'Absensi siswa berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function cekAbsen($idJadwal)
    {
        $absen = AbsensiSiswa::where('id_jadwal', $idJadwal)->where('tanggal', Carbon::now()->format('Y-m-d'))->get();
        if ($absen->isEmpty()) {
            $result = false;   
        }else{
            $result = true;
        }
        return $result;
    }
}
