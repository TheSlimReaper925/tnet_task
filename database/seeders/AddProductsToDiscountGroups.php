<?php

namespace Database\Seeders;

use App\Models\ProductGroupItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddProductsToDiscountGroups extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "group_id" => 1,
                "product_id" => 1
            ],
            [
                "group_id" => 1,
                "product_id" => 2
            ]
        ];

        foreach ($data as $d) {
            ProductGroupItem::create($d);
        }
    }
}
