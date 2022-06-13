<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DosenModel extends Model
{
    protected $fillable = ['nidn','nama'];
    protected $table = 'dosen_models';
	
}
