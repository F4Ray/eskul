<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class MasterGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = Guru::latest()->get();
        // dd($data->user->username);
        if ($request->ajax()) {
            $data = Guru::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('username', function ($row) {
                    return $row->user->username;
                })
                ->addColumn('detail', function ($row) {
                    $detailBtn = '<a href="' . route('master_guru.show', $row->id) . '" class="btn btn-block btn-info btn-sm">Lihat Detail</a>';
                    return $detailBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master_guru.edit', $row->id) . '" class="edit btn btn-block btn-success btn-sm">Edit</a>';
                    $actionBtn .= '<form ' .
                        ' action="' . route('master_guru.destroy', $row->id) . '" method="post">' .
                        csrf_field() .
                        method_field("DELETE") .
                        '<button type="submit" class="btn btn-sm btn-block btn-danger  show_confirm mt-1" data-toggle="tooltip" name="delete">Hapus</button>
            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'detail'])
                ->make(true);
        }
        return view('master.guru.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guruTerakhir = User::where('id_role', 2)->latest()->first();

        $kode = '0000000000';
        if ($guruTerakhir == null) {
            $jadiKode = '00001';
        } else {
            $kode = $guruTerakhir->username + 1;
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
        $mapels = Mapel::all();
        return view('master.guru.create', compact('mapels', 'jadiKode'));
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
                'nama' => 'required',
                'nip' => 'unique:guru|numeric',
            ],
            [
                'nip.unique' => 'NIP sudah digunakan.',
                'nip.numeric' => 'NIP hanya boleh angka.'
            ]
        );
        // dd($request->all());

        $user = new User;
        $user->username = $request->username;
        $user->id_role = 2;
        $user->password = bcrypt('123456');

        $guru = new Guru;
        $guru->nip = $request->nip;
        $guru->nama = $request->nama;
        $guru->jenis_kelamin = $request->jenis_kelamin;
        $guru->tempat_lahir = $request->tempat_lahir;
        $guru->tanggal_lahir = $request->tanggal_lahir;
        $guru->agama = $request->agama;
        $guru->alamat = $request->alamat;
        $guru->no_hp = $request->no_hp;
        $guru->email = $request->email;
        $guru->foto = $request->foto;
        $guru->id_mata_pelajaran = 1111;

        $guru->save();
        $guru->mapel()->attach($request->id_mata_pelajaran);
        $guru->user()->save($user);

        return redirect()->route('master_guru.index')
            ->with('success', '<strong>Data dan akun guru berhasil disimpan !</strong> Silahkan login
            menggunakan NIP dan password 123456, Lalu ubah password.');

        // dd('Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guru = Guru::findOrFail($id);
        return view('master.guru.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guruTerakhir = User::where('id_role', 2)->latest()->first();

        $kode = '0000000000';
        if ($guruTerakhir == null) {
            $jadiKode = '00001';
        } else {
            $kode = $guruTerakhir->username + 1;
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
        $guru = Guru::find($id);
        $guruArray = [];
        foreach ($guru->mapel as $mapel) {
            array_push($guruArray, $mapel->id);
        }
        $mapels = Mapel::all();
        return view('master.guru.update', compact('guru', 'mapels', 'guruArray', 'jadiKode'));
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

        $guru = Guru::findOrFail($id);
        $guru->nip = $request->nip;
        $guru->nama = $request->nama;
        $guru->tempat_lahir = $request->tempat_lahir;
        $guru->tanggal_lahir = $request->tanggal_lahir;
        $guru->jenis_kelamin = $request->jenis_kelamin;
        $guru->agama = $request->agama;
        $guru->alamat = $request->alamat;
        $guru->no_hp = $request->no_hp;
        $guru->id_mata_pelajaran = 1111;
        $guru->email = $request->email;


        $guru->save();

        $guru->mapel()->sync($request->id_mata_pelajaran);

        return redirect()->route('master_guru.index')
            ->with('success', 'Data guru berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guru = Guru::find($id);
        $guru->delete();
        $guru->user()->delete();

        return redirect()->route('master_guru.index')
            ->with('successHapus', 'Data guru berhasil dihapus!');
    }
}