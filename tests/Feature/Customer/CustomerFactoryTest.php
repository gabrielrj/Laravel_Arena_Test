<?php

namespace Tests\Feature\Customer;

use App\Interfaces\Factories\CustomerFactoryInterface;
use App\Models\Customer;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Tests\TestCase;

class CustomerFactoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_factory_method_create_one_customer()
    {
        $factory = App::make(CustomerFactoryInterface::class);

        UserProfile::factory()->create();

        $user = User::factory()->create();

        $customer = $factory->getCustomer($user->id, 'Customer name', '11122233');

        $this->assertInstanceOf(Customer::class, $customer);
    }
}
