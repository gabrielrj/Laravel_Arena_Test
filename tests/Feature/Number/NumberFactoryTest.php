<?php

namespace Tests\Feature\Number;

use App\Interfaces\Factories\NumberFactoryInterface;
use App\Models\Customer;
use App\Models\Number;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class NumberFactoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_factory_method_create_one_number()
    {
        $factory = App::make(NumberFactoryInterface::class);

        UserProfile::factory()->create();

        $user = User::factory()->create();

        $customer = Customer::factory()->create(['user_id' => $user->id]);

        $newNumber = $factory->getNumber($customer->id, '2112451245');

        $this->assertInstanceOf(Number::class, $newNumber);
    }
}
