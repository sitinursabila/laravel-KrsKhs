<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class TaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ta = DB::table('tahun_ajarans')->paginate(3);
        return view('Ta.index',compact('ta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ta.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('tahun_ajarans')->insert([
            'tahun_awal'=>$request->tahun_awal,
       ]);
        return redirect()->route('ta.index');
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
        $data = DB::table('tahun_ajarans')->where('id',$id)->first();

        return view('ta.edit',compact('data'));
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
        DB::table('tahun_ajarans')->where('id',$id)->update([
            'tahun_awal'=>$request->tahun_awal
        ]);
         return redirect()->route('ta.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('tahun_ajarans')->where('id',$id)->delete();
        return redirect()->route('ta.index');
    }
}
