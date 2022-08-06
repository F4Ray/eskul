<?php

namespace App\Http\Controllers;

use App\Models\AbsensiGuru;
use App\Models\Guru;
use App\Models\KeteranganAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;

class AbsensiGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role->role === 'guru') {
            $guru = Auth::user()->guru;
            // $absensi = AbsensiGuru::where('id_guru', $guru->id)->get();

            if ($request->ajax()) {
                $data = AbsensiGuru::where('id_guru', $guru->id)->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal', function ($row) {
                        return Carbon::parse($row->tanggal)->isoFormat('dddd, D MMMM Y');
                    })
                    ->addColumn('keterangan', function ($row) {
                        return $row->keterangan->keterangan;
                    })
                    ->make(true);
            }
            return view('absensi.guru.index');

            // return view('absensi.guru.index', compact('guru', 'absensi'));
        } else {
            if ($request->ajax()) {
                $data = AbsensiGuru::get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('nama_guru', function ($row)
                    {
                        return $row->guru->nama;
                    })
                    ->addColumn('tanggal', function ($row) {
                        return Carbon::parse($row->tanggal)->isoFormat('dddd, D MMMM Y');
                    })
                    ->addColumn('keterangan', function ($row) {
                        return $row->keterangan->keterangan;
                    })
                    ->addColumn('action', function ($row) {
                        $actionBtn = '<a href="' . route('absensi_guru.edit', $row->id) . '" class="edit btn btn-block btn-success btn-sm">Edit</a>';
                        $actionBtn .= '<form ' .
                            ' action="' . route('absensi_guru.destroy', $row->id) . '" method="post">' .
                            csrf_field() .
                            method_field("DELETE") .
                            '<button type="submit" class="btn btn-sm btn-block btn-danger  show_confirm mt-1" data-toggle="tooltip" name="delete">Hapus</button>
                </form>';
                        return $actionBtn;
                    })
                    ->make(true);
            }
            return view('absensi.guru.index');
        }
        // return view('absensi.guru.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $tanggalHariIni = Carbon::now()->toDateString();
        $keterangans = KeteranganAbsensi::all();
        if (Auth::user()->role->role === 'guru') {
            $guru = Auth::user()->guru;
            // return view('absensi.guru.create', compact('guru', 'tanggalHariIni', 'keterangans'));
        } else {
            $guru = Guru::get();
        }
        return view('absensi.guru.create', compact('guru', 'tanggalHariIni', 'keterangans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tanggalHariIni = Carbon::now()->toDateString();
        if (Auth::user()->role->role === 'guru') {
            if ($request->nama != Auth::user()->guru->nama || $request->tanggal != $tanggalHariIni) {
                return redirect()->back()
                    ->withErrors(['msg' => 'Data tidak sesuai'])
                    ->withInput();
            } else {
                $absensiGuru = new AbsensiGuru;
                $absensiGuru->id_guru = Auth::user()->guru->id;
                $absensiGuru->tanggal = $request->tanggal;
                $absensiGuru->semester = 'Ganjil'; // ini nanti diganti dari sistem
                $absensiGuru->tahun_ajaran = '2022/2023'; //ini nanti di ganti dari sistem
                $absensiGuru->id_keterangan_absensi = $request->keterangan;

                $absensiGuru->save();
                return redirect()->route('guru.home')
                    ->with('success', 'Terimakasih telah mengisi absensi.');
            }
        }else{
            // dd($request->all());
           if ($this->cekAbsenGuru($request->guru,$request->tanggal,"Ganjil")) {
            $absensiGuru = new AbsensiGuru;
            $absensiGuru->id_guru = $request->guru;
            $absensiGuru->tanggal = $request->tanggal;
            $absensiGuru->semester = 'Ganjil'; // ini nanti diganti dari sistem
            $absensiGuru->tahun_ajaran = '2022/2023'; //ini nanti di ganti dari sistem
            $absensiGuru->id_keterangan_absensi = $request->keterangan;

            $absensiGuru->save();

            return redirect()->route('absensi_guru.index')
                ->with('success', 'Terimakasih telah mengisi absensi.');
           }else{
            return Redirect::back()->withErrors(['msg' => 'Absensi di tanggal tersebut telah diisi.']);
           }
        }
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
        $absensi_guru = AbsensiGuru::findOrFail($id);
        $keterangans = KeteranganAbsensi::all();
        return view('absensi.guru.update', compact('absensi_guru','keterangans'));
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
        $absensi_guru = AbsensiGuru::findOrFail($id);
        $absensi_guru->id_keterangan_absensi = $request->keterangan;
        $absensi_guru->save();

        return redirect()->route('absensi_guru.index')
                ->with('success', 'Sukses mengubah data absensi.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $absensi_guru = AbsensiGuru::find($id);
        $absensi_guru->delete();

        return redirect()->route('absensi_guru.index')
            ->with('successHapus', 'Data guru berhasil dihapus!');
    }
    
    public function cekAbsenGuru($idGuru, $tanggal, $semester, $tahunAjaran = '2022/2023')
    {
        $result = AbsensiGuru::where('id_guru', $idGuru)->where('tanggal', $tanggal)->where('semester', $semester)->where('tahun_ajaran', $tahunAjaran)->get();

        if($result->isEmpty())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
