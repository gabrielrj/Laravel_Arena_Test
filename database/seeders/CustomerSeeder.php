<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Customer::query()->count() < 10){
            User::all()->each(function (User $user){
                $user->customers()->createMany(Customer::factory(1)->make()->toArray());
            });
        }
    }
}
