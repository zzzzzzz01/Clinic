<?php

namespace Database\Seeders;

use App\Models\HospitalizationOrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalizationOrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void 
    {
        HospitalizationOrderItem::create([
            'hospitalization_order_id' => 1,
            'item_type'               => 'test',
            'item_id'                 => 1,
            'quantity'                => 1,
            'price'                   => 30.00,
            'status'                  => 'pending',
            'order_type'              => 'normal',
        ]);

        HospitalizationOrderItem::create([
            'hospitalization_order_id' => 1,
            'item_type'               => 'test',
            'item_id'                 => 2,
            'quantity'                => 1,
            'price'                   => 28.00,
            'status'                  => 'pending',
            'order_type'              => 'normal',
        ]);

        HospitalizationOrderItem::create([
            'hospitalization_order_id' => 1,
            'item_type'               => 'panel',
            'item_id'                 => 1,
            'quantity'                => 1,
            'price'                   => 1500.00,
            'status'                  => 'pending',
            'order_type'              => 'normal',
        ]);

        HospitalizationOrderItem::create([
            'hospitalization_order_id' => 1,
            'item_type'               => 'panel',
            'item_id'                 => 2,
            'quantity'                => 1,
            'price'                   => 2500.00,
            'status'                  => 'pending',
            'order_type'              => 'normal',
        ]);
    }
}
