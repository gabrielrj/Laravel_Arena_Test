<?php

namespace App\Interfaces\Repositories;

interface CustomerRepositoryInterface extends RepositoryInterface
{
    /**
     * Obtém todos os clientes cadastrados por um usuário específico
     * Get customers registereds by user authenticated
     *
     * @param int $userId
     * @param array $relationships | default: empty array []
     * @param string $orderedColumn | default: created_at
     * @param string $orderedType | default: desc
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getAllCustomersByUserId(int    $userId,
                                            array  $relationships = [],
                                            string $orderedColumn = 'created_at',
                                            string $orderedType = 'desc'): \Illuminate\Database\Eloquent\Collection|array;
}
