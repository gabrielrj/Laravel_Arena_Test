<?php

namespace App\Services;

use App\Exceptions\NumberPreferencesCreatedException;
use App\Exceptions\NumberPreferencesDeletedException;
use App\Exceptions\NumberPreferencesNotFoundException;
use App\Exceptions\NumberPreferencesUpdatedException;
use App\Interfaces\Factories\NumberPreferencesFactoryInterface;
use App\Interfaces\Repositories\NumberPreferencesRepositoryInterface;
use App\Models\NumberPreferences;
use Throwable;

class NumberPreferencesService
{
    private $repository;
    private $factory;

    public function __construct(NumberPreferencesRepositoryInterface $repository,
                                NumberPreferencesFactoryInterface $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * Adiciona uma nova preferência para um número
     *
     * @param int $number_id
     * @param string $name
     * @param string $value
     * @return NumberPreferences
     * @throws NumberPreferencesCreatedException
     */
    public function addNumberPreference(int $number_id, string $name, string $value): NumberPreferences
    {
        $newPrefence = $this->factory->getNumberPreferences($name, $value, $number_id);

        if($this->repository->save($newPrefence))
            return $newPrefence;
        else
            throw new NumberPreferencesCreatedException();
    }

    /**
     * Update number preference
     *
     * @throws NumberPreferencesNotFoundException
     * @throws Throwable
     */
    public function editNumberPreference(array $params, int $id): bool
    {
        $number = $this->findPreferenceById($id);

        if(!$number)
            throw new NumberPreferencesNotFoundException();

        return throw_unless($this->repository->update($number, $params), NumberPreferencesUpdatedException::class);
    }

    /**
     * @param int $id
     * @param array $relationships
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findPreferenceById(int $id, array $relationships = []): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->repository->findById($id, $relationships);
    }

    /**
     * Método que retorna todos as preferências para um número específico.
     *
     * @param int $numberId
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getAllPreferencesByNumberId(int $numberId): \Illuminate\Database\Eloquent\Collection|array
    {
        if(!$numberId)
            throw new \InvalidArgumentException('Number id cannot be null.');

        return $this->repository->getAllPreferencesByNumberId($numberId);
    }

    /**
     *
     * @param int $id
     * @return bool
     * @throws NumberPreferencesNotFoundException
     * @throws Throwable
     */
    public function deleteNumberPreferenceById(int $id) : bool{
        $preference = $this->findPreferenceById($id);

        if(!$preference)
            throw new NumberPreferencesNotFoundException();

        return throw_unless($this->repository->delete($preference), NumberPreferencesDeletedException::class);
    }
}
