<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Yajra\Datatables\Datatables;
use App\Models\Kelas;
use App\Models\NilaiSiswa;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MasterSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role->role === 'siswa') {
            return redirect()->route('master_siswa.show', Auth::user()->siswa->id);
        }
        if ($request->ajax()) {
            $data = Siswa::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('kelas', function ($row) {
                    if ($row->id_kelas == null) {
                        return "-";
                    } else {
                        return $row->kelas->kelas . " " . $row->kelas->rombel;
                    }
                })
                ->addColumn('detail', function ($row) {
                    $detailBtn = '<a href="' . route('master_siswa.show', $row->id) . '" class="btn btn-block btn-info btn-sm">Lihat Detail</a>';
                    return $detailBtn;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('master_siswa.edit', $row->id) . '" class="edit btn btn-block btn-success btn-sm">Edit</a>';
                    $actionBtn .= '<form ' .
                        ' action="' . route('master_siswa.destroy', $row->id) . '" method="post">' .
                        csrf_field() .
                        method_field("DELETE") .
                        '<button type="submit" class="btn btn-sm btn-block btn-danger  show_confirm mt-1" data-toggle="tooltip" name="delete">Hapus</button>
            </form>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'detail'])
                ->make(true);
        }
        return view('master.siswa.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelasKosong = $this->ambilKelasKosong();
        $kelases = Kelas::whereIn('id', $kelasKosong)->get();
        return view('master.siswa.create', compact('kelases'));
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
                'nis' => 'required|unique:siswa|numeric',
                'nisn' => 'numeric|nullable'
            ],
            [
                'nis.unique' => 'NIS sudah digunakan. Silahkan login menggunakan NIP tersebut untuk melengkapi data.',
                'nis.numeric' => 'NIS hanya boleh angka.',
                'nisn.numeric' => 'NISN hanya boleh angka.',
                'nis.required' => 'NIS harus diisi',
                'nama.required' => 'Nama harus diisi'
            ]
        );


        $user = new User;
        $user->username = $request->nis;
        $user->id_role = 3;
        $user->password = bcrypt('123456');

        $siswa = new Siswa;
        $siswa->nis = $request->nis;
        $siswa->nisn = $request->nisn;
        $siswa->nama = $request->nama;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->tempat_lahir = $request->tempat_lahir;
        $siswa->tanggal_lahir = $request->tanggal_lahir;
        $siswa->agama = $request->agama;
        $siswa->alamat = $request->alamat;
        $siswa->no_hp = $request->no_hp;
        $siswa->foto = 'avatar-4.png';
        $siswa->email = $request->email;
        $siswa->id_kelas = $request->kelas;

        
        

        $siswa->save();
        $siswa->user()->save($user);

        if ($request->kelas) {
            $jadwalnya = JadwalPelajaran::where('id_kelas', $request->kelas)->pluck("id");
            
            foreach($jadwalnya as $jadwal){
                $nilai = new NilaiSiswa;
                $nilai->id_jadwal = $jadwal;
                $siswa->nilai()->save($nilai);
            }
        } 

        return redirect()->route('master_siswa.index')
            ->with('success', '<strong>Data dan akun siswa berhasil disimpan !</strong> Silahkan login
            menggunakan NIS dan password 123456, Lalu ubah password.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('master.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelasKosong = $this->ambilKelasKosong();
        $kelases = Kelas::whereIn('id', $kelasKosong)->get();
        return view('master.siswa.update', compact('kelases', 'siswa'));
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
                'nis' => 'numeric',
                'nisn' => 'numeric|nullable'
            ],
            [
                'nis.unique' => 'NIS sudah digunakan. Silahkan login menggunakan NIP tersebut untuk melengkapi data.',
                'nis.numeric' => 'NIS hanya boleh angka.',
                'nisn.numeric' => 'NISN hanya boleh angka.',
                'nis.required' => 'NIS harus diisi',
                'nama.required' => 'Nama harus diisi'
            ]
        );
        $siswa = Siswa::findOrFail($id);
        $siswa->nama = $request->nama;
        $siswa->nisn = $request->nisn;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->tempat_lahir = $request->tempat_lahir;
        $siswa->tanggal_lahir = $request->tanggal_lahir;
        $siswa->agama = $request->agama;
        $siswa->alamat = $request->alamat;
        $siswa->no_hp = $request->no_hp;
        $siswa->email = $request->email;

        $siswa->save();
        if ($request->kelas) {
            $jadwalnya = JadwalPelajaran::where('id_kelas', $request->kelas)->pluck("id");
            
            foreach($jadwalnya as $jadwal){
                $nilai = new NilaiSiswa;
                $nilai->id_jadwal = $jadwal;
                $siswa->nilai()->save($nilai);
            }
        } 

        if (Auth::user()->role->role === 'siswa') {
            return redirect()->route('master_siswa.show',$id)
            ->with('success', 'Data siswa berhasil diedit.');
        }else{
            return redirect()->route('master_siswa.index')
            ->with('success', 'Data siswa berhasil diedit.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        $siswa->user()->delete();
        $siswa->nilai()->delete();
        #

        return redirect()->route('master_siswa.index')
            ->with('successHapus', 'Data siswa berhasil dihapus!');
    }

    public function ambilKelasKosong()
    {
        $kelases = Kelas::all();
        $kelasKosong = array();
        foreach ($kelases as $kelas) {
            $siswa = Siswa::where('id_kelas', $kelas->id)->get();
            if ($siswa->count() < $kelas->max_jumlah) {
                array_push($kelasKosong, $kelas->id);
            }
        }
        return $kelasKosong;
    }

    public function changePicture($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('master.siswa.gantifoto', compact('siswa'));
    }

    public function savePicture(Request $request, $id)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
    
           ]);
        $name = $request->file('image')->getClientOriginalName();
        $image = explode(".", $name);
        $image_extension = array_slice($image , -1, 1);
        $data['image'] = "guru-".$request->id."-".time().'.'.$image_extension[0];
        
        $siswa = Siswa::findOrFail($request->id);
        $fotoLama = $siswa->foto;
        $siswa->foto = $data['image'];
        if($fotoLama != "avatar-4.png"){
        unlink(storage_path('app/public/assets/img/avatar/'.$fotoLama));
        }
        $request->file('image')->storeAs('public/assets/img/avatar',$data['image']);
        $siswa->save();
        return redirect()->route('master_siswa.gantifoto', $id)
            ->with('success', 'Foto siswa berhasil diubah');
    }
}