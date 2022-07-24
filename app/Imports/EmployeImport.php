<?php

namespace App\Imports;

use App\Models\Employe;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Employe([
            'nama' => $row[1],
            'jeniskelamin' => $row[2],
            'notelpon' => $row[3],
            'foto' => $row[4],
        ]);
    }
}
