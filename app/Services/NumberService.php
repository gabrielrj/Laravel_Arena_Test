<?php

namespace App\Services;

use App\Events\NumberAdded;
use App\Exceptions\NumberCreatedException;
use App\Exceptions\NumberDeletedException;
use App\Exceptions\NumberNotFoundException;
use App\Exceptions\NumberUpdatedException;
use App\Interfaces\Factories\NumberFactoryInterface;
use App\Interfaces\Repositories\NumberRepositoryInterface;
use App\Models\Number;
use Illuminate\Support\Facades\DB;
use Throwable;

class NumberService
{
    private $repository;
    private $factory;

    public function __construct(NumberRepositoryInterface $repository,
                                NumberFactoryInterface $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * Adiciona um novo número para um customer
     *
     * @param int $customer_id
     * @param string $number
     * @param string|null $status
     * @return Number
     * @throws NumberCreatedException
     */
    public function addNumber(int $customer_id, string $number, string $status = null): Number
    {
        DB::beginTransaction();

        try {
            $newNumber = $this->factory->getNumber($customer_id, $number, $status);

            if($this->repository->save($newNumber)) {
                event(new NumberAdded($newNumber)); //call listener for add default preferences | chama listener para adicionar preferências padrão

                DB::commit();

                return $newNumber;
            }
            else
                throw new NumberCreatedException();
        }catch (\Exception $exception){
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * @throws NumberNotFoundException
     * @throws Throwable
     */
    public function editNumber(array $params, int $id): bool
    {
        $number = $this->findNumberById($id);

        if(!$number)
            throw new NumberNotFoundException();

        return throw_unless($this->repository->update($number, $params), NumberUpdatedException::class);
    }

    /**
     * @param int $id
     * @param array $relationships
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findNumberById(int $id, array $relationships = []): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->findById($id, $relationships);
    }

    /**
     * Método que retorna todos os numbers cadastrados no sistema.
     *
     * @param array $relationships : Relacionamentos da entidade Customer
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getAllNumbers(array $relationships = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->repository->getAll($relationships);
    }

    /**
     * Método que retorna todos os numbers cadastrados no sistema filtrando pelo id de seu respectivo customer.
     *
     * @param int $customerId
     * @param array $relationships : Relacionamentos da entidade Customer
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getAllNumbersByCustomerId(int $customerId, array $relationships = []): \Illuminate\Database\Eloquent\Collection|array
    {
        if(!$customerId)
            throw new \InvalidArgumentException('Customer id cannot be null.');

        return $this->repository->getAllNumbersByCustomerId($customerId, $relationships);
    }

    /**
     * @throws NumberNotFoundException
     * @throws Throwable
     */
    public function deleteNumberById(int $id){
        $number = $this->findNumberById($id);

        if(!$number)
            throw new NumberNotFoundException();

        return throw_unless($this->repository->delete($number), NumberDeletedException::class);
    }
}
