<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class MahasiswaModel extends Model
{
    protected $table = "mahasiswa_models";
 
    public function getMhs($id=false){

        if($id == false){
            return DB::table('mahasiswa_models')
               ->select('mahasiswa_models.*','jurusan_models.*')
            ->join('jurusan_models','jurusan_models.id_jur','mahasiswa_models.id_jur')
            ->get();
        }
        return $this->where(['Nim'=>$id])->first();
    }
   
      
}
