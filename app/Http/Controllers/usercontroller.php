<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MahasiswaModel;
use Illuminate\Support\Facades\Session;

use DB;

class userController extends Controller
{
    
    protected $mahasiswa;

	public function __construct(){
        $this->mahasiswa = new MahasiswaModel();

	}
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $nim = $request->Nim;
        $Nama = $request->Nama;
        $data=DB::table('mahasiswa_models')->where('Nim',$nim)
        ->where('Nama',$Nama)->first();
        if($data){
            session([
                       'SessionLogin' => "success"
            ]);
             Session::put('Nim', $data->Nim);
             Session::put('Nama',$data->Nama);
                return redirect('/login');
           
        }else{
            return redirect('/user')->with('warning', 'Gagal ! No Induk Tidak Terdaftar');
        }   
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function biodata($id){
        echo "hi";
    }
   

}
