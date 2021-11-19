<?php

namespace App\Interfaces\Factories;

use App\Models\Customer;

interface CustomerFactoryInterface
{
    /**
     * Método responsável por fabricar entidade customer e retorna-la para ser salva pelo repositório;
     *
     * @param int $user_id
     * @param string $name
     * @param string $document
     * @param string|null $status
     * @return Customer
     */
    public function getCustomer(int $user_id,
                                string $name,
                                string $document,
                                string $status = null): Customer;
}
