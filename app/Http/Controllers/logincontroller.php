<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use DB;


class logincontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nim = $request->Nim;
        $Nama = $request->Nama;
        $dat=DB::table('mahasiswa_models')->where('Nim',$nim)
        ->where('Nama',$Nama)->first();
        $data= DB::table('mahasiswa_models')->where('Nim',$nim)
        ->join('jurusan_models','jurusan_models.id_jur','mahasiswa_models.id_jur')
        ->join('fakultas_models','fakultas_models.id','jurusan_models.id_fak')
        ->first();
        if($dat){
            session([
                    'SessionLogin' => "success"
            ]);
             Session::put('Nim', $dat->Nim);
             Session::put('Nama',$dat->Nama);
                return  view('user.biodata',compact('data'));
           
        }else{
            return redirect('/user')->with('warning', 'Gagal ! No Induk Tidak Terdaftar');
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
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('user');
    }
}
