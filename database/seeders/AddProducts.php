<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddProducts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["user_id"=>1, "title"=>"produqti 1", "price"=>10],
            ["user_id"=>1, "title"=>"produqti 2", "price"=>15],
            ["user_id"=>1, "title"=>"produqti 3", "price"=>18],
            ["user_id"=>1, "title"=>"produqti 4", "price"=>11],
            ["user_id"=>1, "title"=>"produqti 5", "price"=>5],
            ["user_id"=>1, "title"=>"produqti 6", "price"=>7],
        ];

        foreach ($data as $d) {
            Product::create($d);
        }

    }
}
