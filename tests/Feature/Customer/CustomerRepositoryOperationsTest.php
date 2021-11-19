<?php

namespace Tests\Feature\Customer;

use App\Exceptions\CustomerNotFoundException;
use App\Interfaces\Repositories\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Tests\TestCase;

class CustomerRepositoryOperationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the customer registration with valid data.
     *
     * @return void
     */
    public function test_new_customers_with_valid_data_can_register()
    {
        $repository = App::make(CustomerRepositoryInterface::class);

        UserProfile::factory()->create();

        $user = User::factory()->create();

        $customer = Customer::factory()->make();
        $customer->user_id = $user->id;

        $this->assertTrue($repository->save($customer));
    }

    public function test_new_customers_with_invalid_data_cannot_register()
    {
        $this->expectException(QueryException::class);

        $repository = App::make(CustomerRepositoryInterface::class);

        UserProfile::factory()->create();

        $user = User::factory()->create();

        $customer = new Customer();
        $customer->name = 'customer name';
        $customer->document = '111111111111111111111111111111111111111';
        $customer->user_id = $user->id;

        $repository->save($customer);
    }


}
