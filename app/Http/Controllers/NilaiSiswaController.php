<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\NilaiSiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class NilaiSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $tes = JadwalPelajaran::where('id_kelas', 5)->whereIn('id_mata_pelajaran',$this->dontDuplicate(5))->get();;
        // dd($tes);
    
        $kelases = Kelas::all();
        $jadwals = JadwalPelajaran::all(); 
        if (Auth::user()->role->role === 'guru'){
            $jadwals = JadwalPelajaran::where('id_guru', Auth::user()->guru->id)->groupBy('id_kelas')->get();
        }else{
            $jadwals = JadwalPelajaran::all();
        }
        
        // $jadwalnya = JadwalPelajaran::where('id_kelas', 3)->groupBy('id_mata_pelajaran')->get();
        // dd($jadwalnya);

        return view('nilai.index', compact('kelases','jadwals'));

    }

    public function ajaxKelas(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->role->role === 'guru'){
                $jadwalnya = JadwalPelajaran::where('id_kelas', $request->id_kelas)->where('id_guru', Auth::user()->guru->id)->groupBy('id_mata_pelajaran')->get();
            }else{
                $jadwalnya = JadwalPelajaran::where('id_kelas', $request->id_kelas)->groupBy('id_mata_pelajaran')->get();
                // $jadwalnya = JadwalPelajaran::where('id_kelas', $request->id_kelas)->whereIn($this->dontDuplicate($request->id_kelas))->get();
            }
            $data = view('nilai.ajax-kelas', compact('jadwalnya'))->render();
            return response()->json(['options' => $data]);
        }
    }

    public function lihat(Request $request)
    {
        if (Auth::user()->role->role === 'guru'){
            $jadwal = JadwalPelajaran::findOrFail($request->jadwal);
        }else{
            $kelas = Kelas::findOrFail($request->kelas);
            $jadwal = JadwalPelajaran::findOrFail($request->jadwal);
        }

        // var_dump($request->all());
        // $nilais = NilaiSiswa::where('id_jadwal', $request->jadwal)->distinct()->get();

        if ($request->ajax()) {
            $data = NilaiSiswa::where('id_jadwal', $request->jadwal)->distinct()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('nama',function ($row)
                {
                    return $row->siswa->nama;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('nilai.edit', $row->id) . '" class="edit btn btn-block btn-success btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // dd($nilai);
        if (Auth::user()->role->role === 'guru'){
            return view('nilai.lihat', compact('jadwal'));
        }else{
            return view('nilai.lihat', compact('kelas','jadwal'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $nilai = NilaiSiswa::findOrFail($id);
        return view('nilai.update', compact('nilai'));
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
        $nilai = NilaiSiswa::findOrFail($id);
        $nilai->kkm = $request->nilai_kkm;
        $nilai->tahun_ajaran = '2022/2023';
        $nilai->nilai_tugas = $request->nilai_tugas;
        $nilai->nilai_uts = $request->nilai_uts;
        $nilai->nilai_uas = $request->nilai_uas;

        $nilaiAkhir = (intval($request->nilai_tugas) + intval($request->nilai_uts) + intval($request->nilai_uas)) / 3;
        $nilai->nilai_akhir = $nilaiAkhir;
        $nilai->save();

        return redirect()->route('nilai.index')
            ->with('success', 'Data nilai berhasil berhasil ditambahkan! Silahkan pilih ulang kelas dan mata pelajaran untuk melihat');
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

    public function dontDuplicate($IdKelas)
    {
        return JadwalPelajaran::where('id_kelas', $IdKelas)->pluck('id_mata_pelajaran');
    }
}
