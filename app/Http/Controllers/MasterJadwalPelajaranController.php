<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Mapel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;



class MasterJadwalPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JadwalPelajaran::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kelas', function ($row) {
                    if ($row->kelas == null) {
                        return "-";
                    } else {
                        return $row->kelas->kelas . " " . $row->kelas->rombel;
                    }
                })
                ->addColumn('jam', function ($row) {
                    return $row->jam_mulai . " - " . $row->jam_selesai;
                })
                ->addColumn('mapel', function ($row) {
                    if ($row->id_mata_pelajaran == null) {
                        return "-";
                    } else {
                        return $row->mapel->nama;
                    }
                })
                ->addColumn('guru', function ($row) {
                    if ($row->id_guru == null) {
                        return "-";
                    } else {
                        return $row->guru->nama;
                    }
                })
                // ->addColumn('detail', function ($row) {
                //     $detailBtn = '<a href="' . route('master_jadwal_pelajaran.show', $row->id) . '" class="btn btn-block btn-info btn-sm">Lihat Detail</a>';
                //     return $detailBtn;
                // })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master_jadwal_pelajaran.edit', $row->id) . '" class="edit btn btn-block btn-success btn-sm">Edit</a>';
                    $actionBtn .= '<form ' .
                        ' action="' . route('master_jadwal_pelajaran.destroy', $row->id) . '" method="post">' .
                        csrf_field() .
                        method_field("DELETE") .
                        '<button type="submit" class="btn btn-sm btn-block btn-danger  show_confirm mt-1" data-toggle="tooltip" name="delete">Hapus</button>
            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'detail'])
                ->make(true);
        }
        return view('master.jadwal_pelajaran.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $kelases = Kelas::all();
        $mapels = Mapel::all();
        return view('master.jadwal_pelajaran.create', compact('kelases', 'mapels'));
    }

    public function ajaxKelas(Request $request)
    {
        if ($request->ajax()) {
            $kelas = Kelas::findOrFail($request->id_kelas);
            $mapelnya = Mapel::where('kelas', $kelas->kelas)->get();
            $data = view('master.jadwal_pelajaran.ajax-select', compact('mapelnya'))->render();
            return response()->json(['options' => $data]);
        }
    }

    public function ajaxGuru(Request $request)
    {
        if ($request->ajax()) {
            $gurunya = Guru::where('id_mata_pelajaran', $request->id_mata_pelajaran)->get();
            $data = view('master.jadwal_pelajaran.ajax-guru', compact('gurunya'))->render();
            return response()->json(['options' => $data]);
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
        // DB::enableQueryLog();
        // dd($request->all());
        $validated = $request->validate(
            [
                'id_kelas' => 'required',
                'jam_mulai' => 'date_format:H:i',
                'jam_selesai' => 'date_format:H:i|after:time_start',
                'semester' => 'required',
                'hari' => 'required',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
                'id_mata_pelajaran' => 'required',
                'tahun_ajaran' => 'required'
            ],
            [
                'id_kelas.required' => 'Kolom kelas tidak boleh kosong',
                'semester.required' => 'Kolom semester tidak boleh kosong',
                'hari.required' => 'Kolom hari tidak boleh kosong',
                'jam_mulai.required' => 'Kolom jam mulai tidak boleh kosong',
                'jam_selesai.required' => 'Kolom jam selesai tidak boleh kosong',
                'id_mata_pelajaran.required' => 'Kolom mata pelajaran tidak boleh kosong',
                'tahun_ajaran.required' => 'Kolom tahun ajaran tidak boleh kosong'
            ]
        );
        // $jamPel =   JadwalPelajaran::where('id_kelas', $request->id_kelas)
        //     ->where('semester', $request->semester)
        //     ->where('hari', $request->hari)
        //     ->where('tahun_ajaran', $request->tahun_ajaran)
        //     ->get();
        // $query = DB::getQueryLog();

        // $query = end($query);
        // $cektimemulai =  array();
        // $cektimeselesai =  array();
        // foreach ($jamPel as $jam) {
        //     var_dump($jam->jam_mulai);
        //     var_dump($jam->jam_selesai);
        //     if ($request->jam_mulai > $jam->jam_mulai and $request->jam_mulai < $jam->jam_selesai) {
        //         echo "jam mulai diantara jam mulai dan selesai, ";
        //         array_push($cektimemulai, false);
        //         //cek udah diambil, jika false, maka sudah diambil
        //     } else {
        //         array_push($cektimemulai, true);
        //     }
        //     if ($request->jam_selesai > $jam->jam_mulai and $request->jam_selesai < $jam->jam_selesai) {
        //         echo "jam selesai diantara jam mulai dan selesai";
        //         array_push($cektimeselesai, false);
        //     } else {
        //         array_push($cektimeselesai, true);
        //     }
        // }

        $hasilCekWaktuMulai = $this->cekWaktuMulai($request->all());
        $hasilCekWaktuSelesai = $this->cekWaktuSelesai($request->all());
        if ($hasilCekWaktuMulai == false) {
            return redirect()->back()
                ->withErrors(['msg' => 'Waktu mulai sudah terisi'])
                ->withInput();
            // Redirect::back()->withErrors(['msg' => 'Waktu mulai sudah terisi'])
            //     ->withInput();
        }

        if ($hasilCekWaktuSelesai == false) {
            return redirect()->back()
                ->withErrors(['msg' => 'Waktu selesai sudah terisi'])
                ->withInput();
            // Redirect::back()->withErrors(['msg' => 'Waktu mulai sudah terisi'])
            //     ->withInput();
        }

        // var_dump($cektimeselesai);
        // var_dump($request->all());

        // dd($this->cekWaktuMulai($request->all()));
        // dd($query);
        // dd($jamPel);


        JadwalPelajaran::create($request->all());
        return redirect()->route('master_jadwal_pelajaran.index')
            ->with('success', 'Data jadwal berhasil disimpan!');
    }


    public function cekWaktuMulai($request)
    {
        // dd($request);
        $jamPel = JadwalPelajaran::where('id_kelas', $request['id_kelas'])
            ->where('semester', $request['semester'])
            ->where('hari', $request['hari'])
            ->where('tahun_ajaran', $request['tahun_ajaran'])
            ->get();
        $cektimemulai = array();
        foreach ($jamPel as $jam) {
            $jamConvMulai = Carbon::parse($jam['jam_mulai'])->format('H:i');
            $jamConvSelesai = Carbon::parse($jam['jam_selesai'])->format('H:i');
            // var_dump($jamConvMulai);
            // var_dump($jamConvSelesai);
            // var_dump($jam['jam_mulai']);
            // var_dump($jam['jam_selesai']);
            if ($request['jam_mulai'] < $jamConvSelesai and $request['jam_mulai'] > $jamConvMulai) {
                // echo "jam mulai diantara jam mulai dan selesai, ";
                array_push($cektimemulai, false);
                //cek udah diambil, jika false, maka sudah diambil
            } else {
                array_push($cektimemulai, true);
            }
        }
        if (in_array(false, $cektimemulai)) {
            $hasilcek = false;
        } else {
            $hasilcek = true;
        }
        // dd($hasilcek);
        return $hasilcek;
    }

    public function cekWaktuSelesai($request)
    {
        // dd($request);
        $jamPel = JadwalPelajaran::where('id_kelas', $request['id_kelas'])
            ->where('semester', $request['semester'])
            ->where('hari', $request['hari'])
            ->where('tahun_ajaran', $request['tahun_ajaran'])
            ->get();
        $cektimeselesai = array();
        foreach ($jamPel as $jam) {
            $jamConvMulai = Carbon::parse($jam['jam_mulai'])->format('H:i');
            $jamConvSelesai = Carbon::parse($jam['jam_selesai'])->format('H:i');
            // var_dump($jamConvMulai);
            // var_dump($jamConvSelesai);
            // var_dump($jam['jam_mulai']);
            // var_dump($jam['jam_selesai']);
            if ($request['jam_selesai'] < $jamConvSelesai and $request['jam_selesai'] > $jamConvMulai) {
                // echo "jam mulai diantara jam mulai dan selesai, ";
                array_push($cektimeselesai, false);
                //cek udah diambil, jika false, maka sudah diambil
            } else {
                array_push($cektimeselesai, true);
            }
        }
        if (in_array(false, $cektimeselesai)) {
            $hasilcek = false;
        } else {
            $hasilcek = true;
        }
        // dd($hasilcek);
        return $hasilcek;
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
        $jadwal = JadwalPelajaran::findOrFail($id);
        $mapelnya = Mapel::where('kelas', $jadwal->kelas->kelas)->get();
        if ($jadwal->id_guru != null) {
            $gurunya = Guru::where('id_mata_pelajaran', $jadwal->id_mata_pelajaran)->get();
        } else {
            $gurunya = null;
        }



        return view('master.jadwal_pelajaran.update', compact('jadwal', 'mapelnya', 'gurunya'));
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
        $jadwal = JadwalPelajaran::findOrFail($id);
        $jadwal->id_mata_pelajaran = $request->id_mata_pelajaran;
        $jadwal->id_guru = $request->id_guru;

        $jadwal->save();

        return redirect()->route('master_jadwal_pelajaran.index')
            ->with('success', 'Data jadwal berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('master_jadwal_pelajaran.index')
            ->with('successHapus', 'Data jadwal berhasil dihapus!');
    }
}