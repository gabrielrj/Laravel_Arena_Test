<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractRepository implements RepositoryInterface
{
    protected string $modelClass;

    /**
     * Retorna o queryBuilder respectivo ao modelclass do repositório.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function newQuery() : Builder {
        return app()->make($this->modelClass)->newQuery();
    }
}
