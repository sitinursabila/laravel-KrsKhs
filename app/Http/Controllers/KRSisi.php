<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MahasiswaModel;
use DB;
use PDF;
class KRSisi extends Controller
{
    
    protected $jurusan;

	public function __construct(){
        $this->mahasiswa = new MahasiswaModel();

	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
       //$data = DB::table('mahasiswa_models')
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $i=0;
        $mt=[];
        $mata = $request->mata;
        if($mata != null){
        foreach ($mata as $m){

            $mt[$i] = $m;
            $i++;
        }
        $t = $request->tamp;
        for($x=0;$x<$i;$x++){
            DB::table('krs_models')->insert([
                'id_matkul'=>$mt[$x],
                'Nim'=>$request->Nim
           ]);
        }
        DB::table('mahasiswa_models')->where('Nim',$request->Nim)->update([
            'status' => "ditutup"
        ]);
        $mhs= DB::table('mahasiswa_models')->where('Nim',$request->Nim)
        ->join('jurusan_models','jurusan_models.id_jur','mahasiswa_models.id_jur')
        ->join('fakultas_models','fakultas_models.id','jurusan_models.id_fak')
        ->first();
        $data= DB::table('mahasiswa_models')->where('Nim',$request->Nim)->first();

        $krs = DB::table('krs_models')->where('Nim',$request->Nim)
        ->join('matkul_models','matkul_models.id','krs_models.id_matkul')
        ->join('dosen_models','dosen_models.id','matkul_models.id_dosen')
        ->get();    

        return view('user.print',compact('krs','mhs','data'));

    }else{
        echo "dafakjfkja";
    }
        //return view('user.print',compact('krs'));

       
    }
    public function print($Nim){
        $mhs= DB::table('mahasiswa_models')->where('Nim',$Nim)
        ->join('jurusan_models','jurusan_models.id_jur','mahasiswa_models.id_jur')
        ->join('fakultas_models','fakultas_models.id','jurusan_models.id_fak')
        ->first();
        $data= DB::table('mahasiswa_models')->where('Nim',$Nim)->first();

        $krs = DB::table('krs_models')->where('Nim',$Nim)
        ->join('matkul_models','matkul_models.id','krs_models.id_matkul')
        ->join('dosen_models','dosen_models.id','matkul_models.id_dosen')
        ->where('krs_models.nilai','=',null)
        ->get();    
        $pdf = PDF::loadview('user.print2',['mhs'=>$mhs,'krs'=>$krs,'data'=>$data]);
        $pdf->save(storage_path().'_krs.pdf');
	        return $pdf->download('krs.pdf');
       

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $data= $this->mahasiswa->getMhs($id);  
  
       $date= date_create($data->Angkatan);
       $now = date_create();
       $diff = date_diff($date,$now);
        $t =$diff->y *12;
        $m = $diff->m;
        $hasil = $t +$m;
        $sem = ceil($hasil/6) + 1 ;
        $j = $data->jurusan;
    
       $matkul= DB::table('matkul_models')->where('semester',$sem)->where('jurusan',$data->id_jur)->get();
        
        return view('user.krs',compact('matkul','data'));
        
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
    public function pilih($id)

    {
        $data= DB::table('mahasiswa_models')->where('Nim',$id)->first();

        return view('user.input',compact('data'));
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
