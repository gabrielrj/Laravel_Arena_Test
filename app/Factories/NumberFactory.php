<?php

namespace App\Factories;

use App\Models\Number;

class NumberFactory implements \App\Interfaces\Factories\NumberFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function getNumber(int $customer_id, string $number, string $status = null): Number
    {
        $entitynumber = new Number();
        $entitynumber->customer_id = $customer_id;
        $entitynumber->number = $number;
        $entitynumber->status = $status ??= 'active';

        return $entitynumber;
    }
}
