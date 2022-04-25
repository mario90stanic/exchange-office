<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $timeDate = new \DateTime();

        $defaultValues = [
            [
                'name' => 'JPY',
                'rate' => 107.17,
                'surcharge' => 7.5,
            ],
            [
                'name' => 'GBP',
                'rate' => 0.711178,
                'surcharge' => 5,
            ],
            [
                'name' => 'EUR',
                'rate' => 0.884872,
                'surcharge' => 5,
            ],
        ];

        foreach ($defaultValues as $defaultValue) {
            DB::table('values')->insert([
                'name' => $defaultValue['name'],
                'rate' => $defaultValue['rate'],
                'surcharge' => $defaultValue['surcharge'],
                'updated_at' => $timeDate,
                'created_at' => $timeDate,
            ]);
        }
    }
}
