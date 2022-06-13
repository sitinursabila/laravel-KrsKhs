<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\MatkulModel;
use App\jurusanModel;
use App\DosenModel;

class MatkulController extends Controller
{
    protected $matkul;
    
    protected $jurusan;

	public function __construct(){
		$this->matkul = new MatkulModel();
        $this->jurusan = new JurusanModel();

	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matkul = MatkulModel::join('jurusan_models','jurusan_models.id_jur','matkul_models.jurusan')
        ->join('dosen_models','dosen_models.id','matkul_models.id_dosen')
        ->paginate(3);
        return view('Matkul.index', compact('matkul'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jurusan = jurusanModel::all();
        $dosen= DosenModel::all();
       return view('Matkul.create',compact('jurusan','dosen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->matkul::create([
    		'kode_matkul' => $request->kode_matkul,
    		'Mata_kuliah' => $request->Mata_kuliah,
            'sks' => $request->sks,
    		'semester' => $request->semester,
            'jurusan' => $request->jurusan,
            'id_dosen' => $request->dosen
    	]);
        
        return redirect('/matkul');
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
        $matkul = $this->matkul->getMatkul($id);
        $jurusan = $this->jurusan->getJurusan();

        return view('Matkul.edit', compact('matkul','jurusan'));
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
        $Data = $this->matkul->getMatkul($id);
        $Data->kode_matkul = request('kode_matkul');
        $Data->Mata_kuliah = request('Mata_kuliah');
        $Data->sks = request('sks');
        $Data->semester = request('semester');
        $Data->jurusan = request('jurusan');
        $Data->update($request->all());
  
        return redirect()->route('matkul.index')->with('success','User updated successfully');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $m =$this->matkul->getMatkul($id);
         $m->delete();
  
        return redirect()->route('matkul.index');
                     
    }
}
