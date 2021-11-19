<?php

namespace App\Repositories;

use App\Interfaces\Repositories\AbstractRepository;
use App\Interfaces\Repositories\NumberRepositoryInterface;
use App\Models\Number;
use App\Repositories\Traits\CrudMethods;
use Illuminate\Database\Eloquent\Collection;

class NumberRepository extends AbstractRepository implements NumberRepositoryInterface
{
    use CrudMethods;

    protected string $modelClass = Number::class;

    /**
     * @inheritDoc
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function getAllNumbersByCustomerId(int $customerId, array $relationships = []): Collection|array
    {
        return $this->newQuery()
            ->with($relationships)
            ->whereCustomerId($customerId)
            ->get();
    }
}
