<?php

namespace App\Interfaces\Factories;

use App\Models\Number;

interface NumberFactoryInterface
{
    /**
     * Método responsável por fabricar entidade number e retorna-la para ser salva pelo repositório;
     *
     * @param int $customer_id
     * @param string $number
     * @param string|null $status
     * @return Number
     */
    public function getNumber(int $customer_id,
                              string $number,
                              string $status = null): Number;
}
