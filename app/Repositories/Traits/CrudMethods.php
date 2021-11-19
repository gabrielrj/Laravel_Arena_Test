<?php

namespace App\Repositories\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait CrudMethods
{

    /**
     * @param array $data
     *
     * @return Model
     * @throws BindingResolutionException
     */
    public function create(array $data = []): Model
    {
        return $this->newQuery()->create($data);
    }

    /**
     * .
     *
     * @param Model $model
     *
     * @return bool
     */
    public function save(Model $model): bool
    {
        return $model->save();
    }

    /**
     *
     *
     * @param Model $model
     * @param array $data
     *
     * @return bool
     */
    public function update(Model $model, array $data = []): bool
    {
        return $model->update($data);
    }

    /**
     * .
     *
     * @param Model $model
     *
     * @return bool
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function forceDelete(Model $model): bool
    {
        return $model->forceDelete();
    }

    /**
     * Executa método que retorna todos os registros cadastrados do repositório identificando seus relacionamentos
     *
     * @param array $relationships
     * @return Collection|array
     * @throws BindingResolutionException
     */
    function getAll(array $relationships = [],
                    string $orderedColumn = 'created_at',
                    string $orderedType = 'desc'): Collection|array {
        return $this->newQuery()
            ->with($relationships)
            ->orderBy($orderedColumn, $orderedType)
            ->get();
    }

    /**
     * Busca o modelo do repositório pelo seu id identificando seus relacionamentos
     *
     * @param int $id
     * @param array $relationships
     * @return Model|null
     * @throws BindingResolutionException
     */
    function findById(int $id, array $relationships = []) : ?Model {
        return $this->newQuery()
            ->with($relationships)
            ->find($id);
    }
}
