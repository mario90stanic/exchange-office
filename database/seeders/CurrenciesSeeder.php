<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends Seeder
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
                'discount' => 0,
            ],
            [
                'name' => 'GBP',
                'rate' => 0.711178,
                'surcharge' => 5,
                'discount' => 0,
            ],
            [
                'name' => 'EUR',
                'rate' => 0.884872,
                'surcharge' => 5,
                'discount' => 2,
            ],
        ];

        foreach ($defaultValues as $defaultValue) {
            DB::table('currencies')->insert([
                'name' => $defaultValue['name'],
                'rate' => $defaultValue['rate'],
                'surcharge' => $defaultValue['surcharge'],
                'discount' => $defaultValue['discount'],
                'updated_at' => $timeDate,
                'created_at' => $timeDate,
            ]);
        }
    }
}
