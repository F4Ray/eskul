<?php

namespace App\Http\Controllers;

use App\Models\AbsensiGuru;
use App\Models\KeteranganAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $absensi = AbsensiGuru::where('id_guru', $guru->id);

            if ($request->ajax()) {
                $data = AbsensiGuru::where('id_guru', $guru->id);
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

            return view('absensi.guru.index', compact('guru', 'absensi'));
        } else {
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
            return view('absensi.guru.create', compact('guru', 'tanggalHariIni', 'keterangans'));
        } else {
            return view('absensi.guru.create', 'keterangans');
        }
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
}
