<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employes')->insert([
            'nama' => "alfian",
            'jeniskelamin' => "cowo",
            'notelpon' => "0812212003",
        ]);
    }
}
