<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface NumberRepositoryInterface extends RepositoryInterface
{
    /**
     * Método que retorna todos os números cadastrados para um customer id
     *
     * @param int $customerId
     * @param array $relationships
     * @return Collection|array
     */
    function getAllNumbersByCustomerId(int $customerId, array $relationships = []) : Collection | array;
}
