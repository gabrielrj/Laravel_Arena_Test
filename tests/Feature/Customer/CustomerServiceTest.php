<?php

namespace Tests\Feature\Customer;

use App\Exceptions\CustomerNotFoundException;
use App\Services\CustomerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class CustomerServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_customer_not_registered_expect_customer_exception(){
        $this->expectException(CustomerNotFoundException::class);

        $service = App::make(CustomerService::class);

        $service->deleteCustomerById(3);
    }
}
