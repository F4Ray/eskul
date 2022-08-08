<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class MasterKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kelas::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kelas', function ($row) {
                    return $row->kelas . " " . $row->rombel;
                })
                ->addColumn('walikelas', function ($row) {
                    if ($row->wali_kelas == null) {
                        return "-";
                    } else {
                        return $row->walikelas->nama;
                    }
                })
                ->addColumn('detail', function ($row) {
                    $actionBtn = '<a href="' . route('master_kelas.show', $row->id) . '" class="edit btn btn-block btn-info btn-sm">Lihat Detail    </a>';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master_kelas.edit', $row->id) . '" class="edit btn btn-block btn-success btn-sm">Edit</a>';
                    $actionBtn .= '<form ' .
                        ' action="' . route('master_kelas.destroy', $row->id) . '" method="post">' .
                        csrf_field() .
                        method_field("DELETE") .
                        '<button type="submit" class="btn btn-sm btn-block btn-danger  show_confirm mt-1" data-toggle="tooltip" name="delete">Hapus</button>
            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['action','detail'])
                ->make(true);
        }
        return view('master.kelas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mapelTerakhir = Kelas::latest()->first();
        $gurus = Guru::all();
        $kode = '0000000000';
        if ($mapelTerakhir == null) {
            $jadiKode = '00001';
        } else {
            $kode = $mapelTerakhir->kode + 1;
        }
        if (strlen($kode) == 1) {
            $jadiKode = "0000" . $kode;
        } else if (strlen($kode) == 2) {
            $jadiKode = "000" . $kode;
        } else if (strlen($kode) == 3) {
            $jadiKode = "00" . $kode;
        } else if (strlen($kode) == 4) {
            $jadiKode = "0" . $kode;
        } else if (strlen($kode) == 5) {
            $jadiKode = $kode;
        }
        return view('master.kelas.create', compact('jadiKode', 'gurus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'kode' => 'required|unique:kelas',
                'kelas' => 'required',
                'rombel' => 'required',
                'max_jumlah' => 'integer',
                'tahun_ajaran' => 'required'
            ],
            [
                'kode' => 'Kode mata pelajaran sudah diambil.',
                'max_jumlah' => 'Jumlah tidak boleh huruf'
            ]
        );
        Kelas::create($request->all());
        return redirect()->route('master_kelas.index')
            ->with('success', 'Data kelas berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $kelas = Kelas::findOrFail($id);
        if ($request->ajax()) {
            $data = Siswa::where('id_kelas', $request->id_kelas)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return view('master.kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gurus = Guru::all();
        $kelas = Kelas::findOrFail($id);
        // dd($barang);
        return view('master.kelas.update', compact('gurus', 'kelas'));
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
        $validated = $request->validate(
            [
                'kode' => 'required',
                'kelas' => 'required',
                'rombel' => 'required',
                'max_jumlah' => 'integer',
                'tahun_ajaran' => 'required'
            ],
            [
                'kode' => 'Kode mata pelajaran sudah diambil.',
                'max_jumlah' => 'Jumlah tidak boleh huruf'
            ]
        );
        $kelas = Kelas::findOrFail($id);
        $kelas->max_jumlah = $request->max_jumlah;
        $kelas->wali_kelas = $request->wali_kelas;
        $kelas->save();

        return redirect()->route('master_kelas.index')
            ->with('success', 'Data mata kelas berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mapel = Kelas::find($id);
        $mapel->delete();

        return redirect()->route('master_kelas.index')
            ->with('successHapus', 'Data mata pelajaran berhasil dihapus!');
    }
}