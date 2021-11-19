<?php

namespace App\Services;

use App\Exceptions\CustomerCreatedException;
use App\Exceptions\CustomerDeletedException;
use App\Exceptions\CustomerNotFoundException;
use App\Exceptions\CustomerUpdatedException;
use App\Interfaces\Factories\CustomerFactoryInterface;
use App\Interfaces\Repositories\CustomerRepositoryInterface;
use App\Models\Customer;
use Throwable;

class CustomerService
{
    private $repository;
    private $factory;

    public function __construct(CustomerRepositoryInterface $repository,
                                CustomerFactoryInterface $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * Cria um novo customer
     *
     * @param int $user_id
     * @param string $name
     * @param string $document
     * @param string|null $status
     * @return Customer
     * @throws CustomerCreatedException
     */
    public function createNewCustomer(int $user_id, string $name, string $document, string $status = null): Customer
    {
        $newCustomer = $this->factory->getCustomer($user_id, $name, $document, $status);

        if($this->repository->save($newCustomer))
            return $newCustomer;
        else
            throw new CustomerCreatedException();
    }

    /**
     * @throws CustomerNotFoundException
     * @throws Throwable
     */
    public function editCustomer(array $params, int $id): bool
    {
        $customer = $this->findCustomerById($id);

        if(!$customer)
            throw new CustomerNotFoundException();

        return throw_unless($this->repository->update($customer, $params), CustomerUpdatedException::class);
    }

    /**
     * @param int $id
     * @param array $relationships
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findCustomerById(int $id, array $relationships = []): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->findById($id, $relationships);
    }

    /**
     * Método que retorna todos os customers cadastrados no sistema.
     *
     * @param array $relationships : Relacionamentos da entidade Customer
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getAllCustomers(array $relationships = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->repository->getAll($relationships);
    }

    /**
     * @throws CustomerNotFoundException
     * @throws Throwable
     */
    public function deleteCustomerById(int $id): bool
    {
        $customer = $this->findCustomerById($id);

        if(!$customer)
            throw new CustomerNotFoundException();

        return throw_unless($this->repository->delete($customer), CustomerDeletedException::class);
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getCustomersByUserId(int $userId): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->repository->getAllCustomersByUserId($userId);
    }
}
