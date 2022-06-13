<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class KrsModel extends Model
{
    protected $fillable = ['id_matkul','Nim'];
    protected $table = 'krs_models';

 }
