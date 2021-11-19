<?php

namespace Tests\Feature\Number;

use App\Interfaces\Repositories\CustomerRepositoryInterface;
use App\Interfaces\Repositories\NumberRepositoryInterface;
use App\Models\Customer;
use App\Models\Number;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class NumberRepositoryOperationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the customer registration with valid data.
     *
     * @return void
     */
    public function test_new_customers_with_valid_data_can_register()
    {
        $repository = App::make(NumberRepositoryInterface::class);

        UserProfile::factory()->create();

        $user = User::factory()->create();

        $customer = Customer::factory()->create(['user_id' => $user->id]);

        $number = new Number();
        $number->customer_id = $customer->id;
        $number->number = '1254586365';
        $number->status = 'active';

        $this->assertTrue($repository->save($number));
    }

    public function test_new_customers_with_invalid_data_cannot_register()
    {
        $this->expectException(QueryException::class);

        $repository = App::make(NumberRepositoryInterface::class);

        UserProfile::factory()->create();

        $user = User::factory()->create();

        $customer = Customer::factory()->create(['user_id' => $user->id]);

        $number = new Number();
        $number->customer_id = $customer->id;
        $number->number = '1254586365654654564549989498498';
        $number->status = 'active';

        $this->assertTrue($repository->save($number));
    }
}
