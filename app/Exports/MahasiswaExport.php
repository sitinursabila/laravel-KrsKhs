<?php

namespace App\Exports;

use App\MahasiswaModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class MahasiswaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MahasiswaModel::all();
    }
}
