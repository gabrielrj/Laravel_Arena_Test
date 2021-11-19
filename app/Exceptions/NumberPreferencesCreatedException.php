<?php

namespace App\Exceptions;

use Exception;

class NumberPreferencesCreatedException extends Exception
{
    protected $message = 'An error occurred when trying to register a number preference.';
}
