<?php

namespace App\Repositories;

use App\Interfaces\Repositories\AbstractRepository;
use App\Interfaces\Repositories\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Repositories\Traits\CrudMethods;

class CustomerRepository extends AbstractRepository implements CustomerRepositoryInterface
{
    use CrudMethods;

    protected string $modelClass = Customer::class;

    /**
     * @inheritDoc
     */
    public function getAllCustomersByUserId(int    $userId,
                                            array  $relationships = [],
                                            string $orderedColumn = 'created_at',
                                            string $orderedType = 'desc'): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->newQuery()
            ->with($relationships)
            ->where('user_id', $userId)
            ->orderBy($orderedColumn, $orderedType)
            ->get();
    }
}
