<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use Yajra\Datatables\Datatables;

class MasterMapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Mapel::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master_mapel.edit', $row->id) . '" class="edit btn btn-block btn-success btn-sm">Edit</a>';
                    $actionBtn .= '<form ' .
                        ' action="' . route('master_mapel.destroy', $row->id) . '" method="post">' .
                        csrf_field() .
                        method_field("DELETE") .
                        '<button type="submit" class="btn btn-sm btn-block btn-danger  show_confirm mt-1" data-toggle="tooltip" name="delete">Hapus</button>
            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.mapel.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mapelTerakhir = Mapel::latest()->first();
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
        return view('master.mapel.create', compact('jadiKode'));
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
                'kode' => 'required|unique:mapel',
                'nama' => 'required',
                'kelas' => 'required',
                'kkm' => 'required'
            ],
            [
                'kode' => 'Kode mata pelajaran sudah diambil.'
            ]
        );

        Mapel::create($request->all());

        return redirect()->route('master_mapel.index')
            ->with('success', 'Data mata pelajaran berhasil disimpan!');
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
        $mapel = Mapel::find($id);
        // dd($barang);
        return view('master.mapel.update', compact('mapel'));
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
                'nama' => 'required',
                'kelas' => 'required',
                'kkm' => 'required'
            ],
            [
                'kode' => 'Kode mata pelajaran sudah diambil.'
            ]
        );

        $mapel = Mapel::findOrFail($id);
        $mapel->nama = $request->nama;
        $mapel->kelas = $request->kelas;
        $mapel->kkm = $request->kkm;
        $mapel->save();

        return redirect()->route('master_mapel.index')
            ->with('success', 'Data mata pelajaran berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mapel = Mapel::find($id);
        $mapel->delete();

        return redirect()->route('master_mapel.index')
            ->with('successHapus', 'Data mata pelajaran berhasil dihapus!');
    }
}