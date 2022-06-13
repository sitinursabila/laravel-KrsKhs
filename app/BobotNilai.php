<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BobotNilai extends Model
{
    protected $fillable = ['grade','bobot'];
    protected $table = 'bobot_nilais';
}
