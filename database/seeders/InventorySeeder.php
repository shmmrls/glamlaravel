<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $stocks = [
            [1,50],[2,79],[3,60],[4,30],[5,85],[6,40],[7,25],
            [8,102],[9,69],[10,55],[11,39],[12,63],[13,83],
            [14,20],[15,13],[16,10],[17,75],[18,95],[19,25],
            [20,12],[21,60],[22,50],[23,35],[24,80],[25,100],[26,150],
        ];

        foreach ($stocks as $s) {
            DB::table('inventory')->insert([
                'product_id'    => $s[0],
                'quantity'      => $s[1],
                'unit'          => 'pcs',
                'reorder_level' => 10,
            ]);
        }
    }
}