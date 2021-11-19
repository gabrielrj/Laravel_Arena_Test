<?php

namespace App\Repositories;

use App\Interfaces\Repositories\AbstractRepository;
use App\Interfaces\Repositories\NumberPreferencesRepositoryInterface;
use App\Models\NumberPreferences;
use App\Repositories\Traits\CrudMethods;
use Illuminate\Database\Eloquent\Collection;

class NumberPreferencesRepository extends AbstractRepository implements NumberPreferencesRepositoryInterface
{
    use CrudMethods;

    protected string $modelClass = NumberPreferences::class;

    /**
     * @inheritDoc
     */
    function getAllPreferencesByNumberId($numberId): Collection|array
    {
        return $this->newQuery()
            ->whereNumberId($numberId)
            ->get();
    }
}
