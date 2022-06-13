<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\KrsModel;
use App\DosenModel;
use App\MatkulModel;
use App\BobotNilai;
use Session;
use PDF;

use DB;


class isiKhs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
       $matkul = MatkulModel::all();
       return view('nilai.index',compact('matkul'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah(Request $request)
    {
        $krs =  DB::table('krs_models')
        ->join('mahasiswa_models','mahasiswa_models.Nim','krs_models.Nim')
        ->join('matkul_models','matkul_models.id','krs_models.id_matkul')
        ->where('matkul_models.id',$request->mata_kuliah)
        ->where('krs_models.nilai','=',null)
        ->get();
        $t = $request->mata_kuliah;
        $n = BobotNilai::get();
        $m =DB::table('matkul_models')->where('id',$t)->first();
        return view('nilai.create',compact('krs','m','n'));
    }
    public function create(Request $request)
    {
        // $krs =  KrsModel::join('matkul_models','matkul_models.id','=','krs_models.id_matkul')->get();
        // return view('nilai.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo "fjjfh";
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

    public function tampil(Request $request, $id)
    {
        $krs= DB::table('krs_models')
        ->join('matkul_models','matkul_models.id','krs_models.id_matkul')
        ->join('bobot_nilais','bobot_nilais.bobot','krs_models.nilai')
        ->where('krs_models.Nim',$id)
        ->where('krs_models.nilai','!=',NULL)
        ->where('matkul_models.semester','=',$request->semester)
        ->get();
        $sem =$request->semester;
        $data = DB::table('mahasiswa_models')
            ->join('jurusan_models','jurusan_models.id_jur','mahasiswa_models.id_jur')
            ->join('fakultas_models','fakultas_models.id','jurusan_models.id_fak')
            ->where('Nim',$id)->first();
        
         $t=0;
         $tamp=0;
        foreach($krs as $k){
           $tamp += $k->sks;
           $t += $k->nilai;
        }
        if($tamp==0){
            return view('user.gagal',compact('krs','data'));
            
        }else{
            $n = $tamp*$t/$tamp;
            return view('user.khs',compact('krs','data','n','sem'));
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $m =DB::table('krs_models')
        ->join('mahasiswa_models','mahasiswa_models.Nim','$krs_models.Nim')
        ->join('matkul_models','matkul_models.id','krs_models.id_matkul')
        ->where('Nim',$id)
        ->get();

        return view('nilai.edit',compact('m'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function input(Request $request)
    {
        
        $i=0;
        $a=0;
        $b=0;
        $id=[];
        $n = [];
        $id = $request->id;
        $nilai = $request->nilai;
        if ($nilai) {
            foreach ($nilai as $m){

                $n[$i] = $m;
                
                $i++;
            }
           
            foreach ($id as $m){
    
                $id_matkul[$a] = $m;
                
                $a++;
            }
            for($x=0;$x<$i;$x++){
                DB::table('krs_models')->where('id_krs',$id_matkul[$x])
                ->update([
                    'nilai' => $n[$x]
               ]);
            }
            
            return redirect()->route('nilai.index');
        }else{
            return redirect()->route('nilai.index')->with('pesan','Tidak Ada nilai yang perlu ditambahkan ')->with('alert','succes');

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
        //
    }
    public function print($id){
        $krs= DB::table('krs_models')
        ->join('matkul_models','matkul_models.id','krs_models.id_matkul')
        ->join('bobot_nilais','bobot_nilais.bobot','krs_models.nilai')
        ->where('krs_models.Nim',$id)
        ->where('krs_models.nilai','!=',NULL)
        ->get();
        $data = DB::table('mahasiswa_models')
            ->join('jurusan_models','jurusan_models.id_jur','mahasiswa_models.id_jur')
            ->join('fakultas_models','fakultas_models.id','jurusan_models.id_fak')
            ->where('Nim',$id)->first();
        
            $t=0;
            $tamp=0;
           foreach($krs as $k){
              $tamp += $k->sks;
              $t += $k->bobot * $k->sks;
           }
           dd($tamp);die;
           $n = $tamp * $t / $tamp;
             $pdf = PDF::loadview('user.print3',['krs'=>$krs,'n'=>$n,'data'=>$data]);
            $pdf->save(storage_path().'_khs.pdf');
                return $pdf->download('khs.pdf');

    }
    
}
