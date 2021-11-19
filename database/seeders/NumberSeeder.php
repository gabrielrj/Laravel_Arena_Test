<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Number;
use App\Models\NumberPreferences;
use Illuminate\Database\Seeder;

class NumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::all()->each(function (Customer $customer){
            if($customer->numbers()->count() === 0){
                $numbers = $customer->numbers()->createMany(Number::factory(1)->make()->toArray());

                foreach ($numbers as $number){
                    NumberPreferences::query()->create(['name' => 'auto_attendant', 'value' => '1', 'number_id' => $number->id])
                        ->create(['name' => 'voicemail_enabled', 'value' => '1', 'number_id' => $number->id]);
                }
            }
        });
    }
}
