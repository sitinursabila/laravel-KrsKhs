<?php

namespace App\Http\Controllers;
use App\KrsModel;

use DB;

use Illuminate\Http\Request;

class KrsController extends Controller
{
    protected $krs;
    public function __construct(){
		$this->krs = new KrsModel();

	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $krs= DB::table('krs_models')->join('matkul_models','matkul_models.id','krs_models.id_matkul')->join('mahasiswa_models','mahasiswa_models.Nim','krs_models.Nim')->paginate(3);
        return view('krs.index', compact('krs'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $krs = $this->krs->getKrs();

        return view('krs.edit',compact('krs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $krs =DB::table('krs_models')->where('id_krs',$id)->first();

        return view('krs.edit',compact('krs'));
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
      DB::table('krs_models')->where('id_krs',$id)->delete();
      return redirect()->route('krs.index');
    }
}
