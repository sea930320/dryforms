<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class PsychometricCalculationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('psychometric_calculations')->truncate();
        $dataToImport = [];
        Excel::load('database/seeds/support/psychometric.xlsx', function($reader) use (&$dataToImport) {
            $results = $reader->all()->toArray();
            foreach ($results as $sheet) {
                foreach ($sheet as $row) {
                    $temperature = $row['temp_rh'];
                    unset($row['temp_rh']);
                    foreach ($row as $key => $cell) {
                        if (!is_null($cell)) {
                            $dataToImport[] = [
                                'temperature' => $temperature,
                                'rh' => $key,
                                'result' => (int)$cell
                            ];
                        }
                    }
                }
            }
        });

        \DB::table('psychometric_calculations')->insert($dataToImport);
    }
}
