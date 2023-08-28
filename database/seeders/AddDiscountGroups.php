<?php

namespace Database\Seeders;

use App\Models\UserProductGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddDiscountGroups extends Seeder
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
                "user_id" => 1,
                "discount" => 15
            ],
            [
                "user_id" => 1,
                "discount" => 10
            ]
        ];

        foreach ($data as $d) {
            UserProductGroup::create($d);
        }
    }
}
