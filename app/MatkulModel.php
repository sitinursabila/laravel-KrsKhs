<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class MatkulModel extends Model
{
    
    protected $fillable = ['kode_matkul','Mata_kuliah','sks','semester','jurusan','id_dosen'];
    protected $table = 'matkul_models';
		public function getmatkul($id=false){

			if($id == false){
				return DB::table('matkul_models')
       			->select('matkul_models.*','jurusan_models.*')
        		->join('jurusan_models','jurusan_models.id_jur','matkul_models.jurusan')
        		->get();
			}
			return $this->where(['id'=>$id])->first();
		}
	
}
