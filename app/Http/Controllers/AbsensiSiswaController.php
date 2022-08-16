<?php

namespace App\Http\Controllers;

use App\Models\AbsensiGuru;
use App\Models\AbsensiSiswa;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class AbsensiSiswaController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $hari = 'Senin';
        
        $hari = Carbon::now()->isoFormat('dddd');
        // $hari = 'Senin';
        
        if (Auth::user()->role->role === 'guru') {
            $jadwalGuru = JadwalPelajaran::where('id_guru', Auth::user()->guru->id)->where('hari', $hari)->get();
            // $request->tanggal = Carbon::now()->format('Y-m-d');
        }else{
            $jadwalGuru = JadwalPelajaran::all();
        }
        if ($request->get('jadwal')) {
            if (Auth::user()->role->role === 'admin') {
                $validated = $request->validate(
                    [
                        'jadwal' => 'required',
                        'tanggal' => 'required',
                    ],
                    [
                        'jadwal.required' => 'Kelas tidak boleh kosong.',
                        'tanggal.required' => 'Tanggal tidak boleh kosong.'
                    ]
                );
            }
            $jadwalnya = JadwalPelajaran::findOrFail($request->jadwal);
            $absens = AbsensiSiswa::where('id_jadwal', $request->jadwal)->where('tanggal', $request->tanggal)->get(); //ambil data absen
                // $siswas = Siswa::where('id_kelas', $jadwalnya->kelas->id)->get();
            
            return view('absensi.siswa.index', compact('jadwalGuru', 'absens','jadwalnya'));
        }
        return view('absensi.siswa.index', compact('jadwalGuru'));
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $hari = Carbon::now()->isoFormat('dddd');

        $hari = 'Senin';
        if (Auth::user()->role->role === 'guru') {
            $jadwalGuru = JadwalPelajaran::where('id_guru', Auth::user()->guru->id)->where('hari', $hari)->get();
            $request->tanggal = Carbon::now()->format('Y-m-d');
        }else{
            $jadwalGuru = JadwalPelajaran::all();
        }
        if ($request->get('jadwal')) {
            $jadwalnya = JadwalPelajaran::findOrFail($request->jadwal); 
            if ($this->cekAbsen($request->jadwal, $request->tanggal) === false) {  //cek apakah kosong, jika kosong next
                $siswas = Siswa::where('id_kelas', $jadwalnya->kelas->id)->get(); // jika absensi kosong alias belum ada, maka munculkan siswa untuk di absen
            }else{
                $siswas = false;
                $absens = AbsensiSiswa::where('id_jadwal', $request->jadwal)->where('tanggal', $request->tanggal)->get(); //
                return view('absensi.siswa.create', compact('jadwalGuru', 'siswas','jadwalnya','absens'));
            }
            return view('absensi.siswa.create', compact('jadwalGuru', 'siswas','jadwalnya'));

        }
        return view('absensi.siswa.create', compact('jadwalGuru'));
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
            $absensiSiswa->tanggal = Carbon::now()->format('Y-m-d');
           }else
           {
            $absensiSiswa->tanggal =$request->tanggal;
            $absensiSiswa->id_guru = 9999;
           }
            $absensiSiswa->id_jadwal = $request->id_jadwal;
            $absensiSiswa->tahun_ajaran = '2022/2023';
            $absensiSiswa->id_keterangan_absensi = $request[$siswa->id];
            $absensiSiswa->save();
        }
        if (Auth::user()->role->role === 'guru') {
            return redirect()->route('absensi_siswa.index', [ 'jadwal'=> $request->id_jadwal, 'tanggal' => Carbon::now()->format('Y-m-d') ])
        ->with('success', 'Absensi siswa berhasil disimpan');
        }else {
            return redirect()->route('absensi_siswa.index', [ 'jadwal'=> $request->id_jadwal, 'tanggal' => $request->tanggal ])
        ->with('success', 'Absensi siswa berhasil disimpan');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $absensi = AbsensiSiswa::where('id_siswa', $id)->get();

        $today = today(); 
        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $dates[] = \Carbon\Carbon::createFromDate($today->year, $today->month, $i)->format('Y-m-d');
        }    
        // foreach ($dates as $date) {
        //     var_dump($date);
        // }
        // dd($date);

        // $grouped = $absensi->mapToGroups(function ($item) {
        //     return [$item->jadwal->mapel->nama => [$item->tanggal => $item->keterangan->keterangan]];
        // });


        $matkuls = $absensi->mapToGroups(function ($item) {
            return [$item->jadwal->mapel->nama => [$item->tanggal => $item->keterangan->keterangan]];
        });
        $matkuls = $matkuls->jsonserialize();
        
        $newAr = array();
        foreach ($matkuls as $matkul => $key) {
            foreach ($key as $ka => $keynya) {
                foreach ($keynya as $hari => $keterangan) {
                    $newAr[$matkul][$hari] = $keterangan;
                }
            }
        }
        if ($request->ajax()) {
            $data = AbsensiSiswa::where('id_siswa', $request->siswa)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('keterangan',function ($row)
                {
                    return $row->keterangan->keterangan;
                })
                ->make(true);
        }
        return view('absensi.siswa.show', compact('id','dates','newAr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $date)
    {
        if (Auth::user()->role->role === 'guru') {
            if ($this->cekLoggedInUser($id) === false) {
                return response()->json(['You do not have permission to access for this page.']);
            }
        }
        if (Auth::user()->role->role === 'guru'){
            $listAbsensi = AbsensiSiswa::where('id_jadwal', $id)->where('tanggal', Carbon::now()->format('Y-m-d'))->get();
        }else{
            $listAbsensi = AbsensiSiswa::where('id_jadwal', $id)->where('tanggal', $date)->get();
        }
        $idJadwal = $id;

        return view('absensi.siswa.update', compact('listAbsensi', 'idJadwal'));
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
        $jadwalnya = JadwalPelajaran::findOrFail($id);
        $siswas = Siswa::where('id_kelas', $jadwalnya->kelas->id)->get();
        foreach ($siswas as $siswa) {
            if (Auth::user()->role->role === 'guru') {
                $absensiSiswa = AbsensiSiswa::where('id_siswa', $siswa->id)->where('tanggal', Carbon::now()->format('Y-m-d'))->first();
            }
            else{
                $absensiSiswa = AbsensiSiswa::where('id_siswa', $siswa->id)->where('tanggal', $request->date)->first();
            }
            $absensiSiswa->id_keterangan_absensi = $request[$siswa->id];
            $absensiSiswa->save();
        }
        if (Auth::user()->role->role === 'guru') {
            return redirect()->route('absensi_siswa.index', [ 'jadwal'=> $id, 'tanggal' => Carbon::now()->format('Y-m-d') ])
        ->with('success', 'Absensi siswa berhasil disimpan');
        }else {
            return redirect()->route('absensi_siswa.index', [ 'jadwal'=> $id, 'tanggal' => $request->date ])
        ->with('success', 'Absensi siswa berhasil disimpan');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $date)
    {
        if (Auth::user()->role->role === 'guru') {
            return response()->json(['You do not have permission to access for this page.']);   
        }
        AbsensiSiswa::where('id_jadwal', $id)->where('tanggal', $date)->delete();
        return redirect()->route('absensi_siswa.index', [ 'jadwal'=> $id, 'tanggal' => $date ])
        ->with('success', 'Absensi siswa berhasil dihapus');
    }
    
    public function cekAbsen($idJadwal, $tanggal)
    {
        $absen = AbsensiSiswa::where('id_jadwal', $idJadwal)->where('tanggal', $tanggal)->get();
        if ($absen->isEmpty()) {
            $result = false;   
        }else{
            $result = true;
        }
        return $result;
    }

    public function cekLoggedInUser($idJadwal)
    {
        $loggedInUser = Auth::user();
        $jadwal = JadwalPelajaran::findOrFail($idJadwal);
        if ($loggedInUser->guru->id != $jadwal->id_guru) {
            return false; 
        }else{
            return true;
        }
    }
}
