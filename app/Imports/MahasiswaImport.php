<?php

namespace App\Imports;

use App\MahasiswaModel;
use Maatwebsite\Excel\Concerns\ToModel;

class MahasiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new MahasiswaModel([
            'Nim' => $row[1],
            'Nama' => $row[2], 
            'Tanggal_lahir' => $row[3],
            'Jk' => $row[4],
            'id_jur' => $row[5], 
            'Angkatan' => $row[6],
        ]);
    }
}
