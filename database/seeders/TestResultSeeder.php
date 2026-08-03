<?php

namespace Database\Seeders;

use App\Models\TestResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void 
    {
        $results = [
            [1, 1, null, 'g/dL', 13.00, 17.00],
            [2, 2, null, '10^12/L', 4.50, 5.90],
    
            [3, 1, null, 'g/dL', 13.00, 17.00],
            [3, 2, null, '10^12/L', 4.50, 5.90],
            [3, 3, null, '10^9/L', 4.00, 10.00],
            [3, 4, null, '10^9/L', 150.00, 400.00],
            [3, 5, null, '%', 40.00, 50.00],
            [3, 6, null, 'mmol/L', 3.90, 5.50],
            [3, 7, null, 'µmol/L', 62.00, 115.00],
            [3, 8, null, 'mmol/L', 2.50, 8.30],
            [3, 9, null, 'g/L', 64.00, 83.00],
            [3, 10, null, 'g/L', 35.00, 52.00],
            [3, 11, null, 'U/L', 0.00, 41.00],
            [3, 12, null, 'U/L', 0.00, 40.00],
    
            [4, 13, null, 'µmol/L', 5.00, 21.00],
            [4, 14, null, 'µmol/L', 0.00, 5.00],
            [4, 15, null, 'mmol/L', 0.00, 5.20],
            [4, 16, null, 'mmol/L', 1.00, 2.00],
            [4, 17, null, 'mmol/L', 0.00, 3.00],
            [4, 18, null, 'mmol/L', 0.00, 1.70],
            [4, 19, null, 'mmol/L', 3.50, 5.10],
            [4, 20, null, 'mmol/L', 135.00, 145.00],
            [4, 21, null, 'mmol/L', 98.00, 107.00],
            [4, 22, null, 'µIU/mL', 0.40, 4.00],
            [4, 23, null, 'pg/mL', 2.30, 4.20],
        ];
    
        foreach ($results as $index => $result) {
            TestResult::create([
                'hospitalization_order_item_id' => $result[0],
                'test_id' => $result[1],
                'value' => $result[2],
                'unit' => $result[3],
                'normal_min' => $result[4],
                'normal_max' => $result[5],
                'status' => 'pending',
                'resulted_at' => null,
            ]);
        }
    }
}
