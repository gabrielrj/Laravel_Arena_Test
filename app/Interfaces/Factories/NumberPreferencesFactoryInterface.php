<?php

namespace App\Interfaces\Factories;

use App\Models\Customer;
use App\Models\NumberPreferences;

interface NumberPreferencesFactoryInterface
{
    /**
     * Método responsável por fabricar entidade number_preferences e retorna-la para ser salva pelo repositório;
     *
     * @param string $name
     * @param string $value
     * @param int $number_id
     * @return NumberPreferences
     */
    public function getNumberPreferences(string $name,
                                         string $value,
                                         int $number_id): NumberPreferences;
}
