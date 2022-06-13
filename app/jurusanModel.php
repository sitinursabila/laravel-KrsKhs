<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class jurusanModel extends Model
{
    protected $fillable = ['jurusan','id_fak','created_at','updated_at'];
    protected $table = 'jurusan_models';
		public function getJurusan($id=false){

			if($id == false){
                return DB::table('jurusan_models')
                ->select('jurusan_models.*','fakultas_models.*')
               ->join('fakultas_models','fakultas_models.id','jurusan_models.id_fak')
               ->get();
            }
            return $this->where(['id_jur'=>$id])->first();
   }
}
