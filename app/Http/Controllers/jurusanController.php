<?php

namespace App\Http\Controllers;
use App\jurusanModel;
use App\fakultasModel;
use DB;

use Illuminate\Http\Request;

class jurusanController extends Controller
{
    protected $jurusan;
    protected $fakultas;
	
	public function __construct(){
        $this->fakultas = new fakultasModel();
		$this->jurusan = new jurusanModel();
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurusan = jurusanModel::join('fakultas_models','fakultas_models.id','=','jurusan_models.id_fak')->paginate(3);
        return view('jurusan.index', compact('jurusan'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fakultas = $this->fakultas->getFak();
        return view('jurusan.create',compact('fakultas'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->jurusan::create([
    		'jurusan' => $request->jurusan,
            'id_fak' => $request->fakultas
    	]);
        return redirect('/jurusan');
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
        $jurusan = $this->jurusan->getJurusan($id);
        $fakultas = $this->fakultas->getFak();
        return view('jurusan.edit',compact('fakultas','jurusan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        DB::table('jurusan_models')->where('id_jur',$id)->update([
        'jurusan' => $request->jurusan,
        'id_fak' =>$request->id_fak
    ]);
  
        return redirect()->route('jurusan.index')->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $m =$this->jurusan->getJurusan($id);
        $m->delete();
 
       return redirect()->route('jurusan.index');
    }
}
