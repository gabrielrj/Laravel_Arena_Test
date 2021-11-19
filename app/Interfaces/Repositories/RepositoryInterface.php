<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * Retorna o queryBuilder respectivo ao modelclass do repositório.
     *
     * @return Builder
     */
    function newQuery() : Builder;

    /**
     * Cria um objeto Model com as informações do parâmetro $data.
     *
     * @param array $data
     *
     * @return Model
     */
    function create(array $data = []): Model;

    /**
     * Atualiza a model enviada como parâmetro com os dados do array de $data.
     *
     * @param Model $model
     * @param array $data
     *
     * @return bool
     */
    function update(Model $model, array $data = []): bool;

    /**
     * Executa o método de salvamento do modelo, permitindo implementação anterior da lógica de negócio.
     *
     * @param Model $model
     *
     * @return bool
     */
    function save(Model $model): bool;

    /**
     * Executa o método de exclusão lógica do modelo, permitindo implementação anterior da lógica de negócio.
     *
     * @param Model $model
     *
     * @return bool
     */
    function delete(Model $model): bool;


    /**
     * Executa o método de exclusão física do modelo enviado.
     *
     * @param Model $model
     * @return bool
     *
     */
    function forceDelete(Model $model): bool;

    /**
     * Executa método que retorna todos os registros cadastrados do repositório identificando seus relacionamentos
     *
     * @param array $relationships
     * @return Collection|array
     */
    function getAll(array $relationships = [],
                    string $orderedColumn = 'created_at',
                    string $orderedType = 'desc'): Collection|array;

    /**
     * Busca o modelo do repositório pelo seu id identificando seus relacionamentos
     *
     * @param int $id
     * @param array $relationships
     * @return Model|null
     */
    function findById(int $id, array $relationships = []) : ?Model;
}
