<?php

namespace App\Factories;

use App\Models\NumberPreferences;

class NumberPreferencesFactory implements \App\Interfaces\Factories\NumberPreferencesFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function getNumberPreferences(string $name, string $value, int $number_id): NumberPreferences
    {
        $numberPreference = new NumberPreferences();
        $numberPreference->name = $name;
        $numberPreference->value = $value;
        $numberPreference->number_id = $number_id;

        return $numberPreference;
    }
}
