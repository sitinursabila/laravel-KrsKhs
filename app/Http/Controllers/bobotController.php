<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BobotNilai;
class bobotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bobot = BobotNilai::paginate(3);
        return view('bobot.index',compact('bobot'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bobot.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        BobotNilai::create([
    		'grade' => $request->grade,
            'bobot' => $request->bobot

    	]);
        return redirect('/bobot');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bobot = BobotNilai::findorFail($id);
        return view('bobot.edit',compact('bobot'));
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
        $Data = BobotNilai::findorFail($id);
        $Data->grade = request('grade');
        $Data->bobot = request('bobot');
        $Data->update($request->all());
  
        return redirect()->route('bobot.index')->with('success','User updated successfully');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $m = BobotNilai::findorFail($id);
         $m->delete();
  
        return redirect()->route('bobot.index');
    }
}
