<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface NumberPreferencesRepositoryInterface extends RepositoryInterface
{
    /**
     * Retorna todas preferĂȘncias cadastradas para um numberId
     *
     * @param $numberId
     * @return Collection|array
     */
    function getAllPreferencesByNumberId($numberId) : Collection|array;
}
