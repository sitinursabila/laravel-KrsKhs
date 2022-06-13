<?php

namespace App\Http\Controllers;
use App\MahasiswaModel;
use App\jurusanModel;
use DB;
use Illuminate\Http\Request;
class mahasiswaControlller extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswa = MahasiswaModel::join('jurusan_models', 'jurusan_models.id_jur', '=', 'mahasiswa_models.id_jur')
        ->select('mahasiswa_models.*','jurusan_models.jurusan')->paginate(3);
        return view('mahasiswa.index', compact('mahasiswa'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = DB::table('tahun_ajarans')->get();
        $jurusan = jurusanModel::all();

        return view('mahasiswa.create',compact('jurusan','data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nim' => 'required|unique:mahasiswa_models'
        ]
    );
        $id = $request->jurusan;
        $tamp=0;
        $data = DB::table('matkul_models')->where('jurusan',$id)->get();
            foreach ($data as $k) {
               $tamp += $k->sks;
            }
           
        DB::table('mahasiswa_models')->insert([
    		'Nim' => $request->Nim,
    		'Nama' => $request->Nama,
            'Tanggal_lahir' => $request->Tanggal_lahir,
    		'Jk' => $request->Jk,
            'id_jur' => $request->jurusan,
            'sks_tempuh' => $tamp,
            'Angkatan' => $request->Angkatan,
            'status' => "dibuka"
    	]);
 
        return redirect('/mhs');
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
        $mahasiswa = DB::table('mahasiswa_models')->where('Nim',$id)->first();
        $data = DB::table('tahun_ajarans')->get();

        $jurusan = JurusanModel::all();
        
        return view('mahasiswa.edit',compact('mahasiswa','jurusan','data'));
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
        DB::table('mahasiswa_models')->where('Nim',$id)->update([
            'Nim' => $request->Nim,
           'Nama' => $request->Nama,
           'Tanggal_lahir' => $request->Tanggal_lahir,
           'Jk' => $request->Jk,
           'id_jur' => $request->id_jur,
           'Angkatan' => $request->Angkatan,
           'status' =>$request->status  
    
        ]);
        
        return redirect()->route('mhs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $m= DB::table('mahasiswa_models')->where('Nim',$id)->delete();
        
 
       return redirect()->route('mhs.index');
   
    }
}
