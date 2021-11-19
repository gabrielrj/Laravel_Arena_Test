<?php

namespace App\Factories;

use App\Models\Customer;

class CustomerFactory implements \App\Interfaces\Factories\CustomerFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function getCustomer(int $user_id, string $name, string $document, string $status = null): Customer
    {
        $customer = new Customer();
        $customer->user_id = $user_id;
        $customer->name = $name;
        $customer->document = $document;
        $customer->status = $status ??= 'new';

        return $customer;
    }
}
