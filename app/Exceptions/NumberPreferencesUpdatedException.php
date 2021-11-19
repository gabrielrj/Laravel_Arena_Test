<?php

namespace App\Exceptions;

use Exception;

class NumberPreferencesUpdatedException extends Exception
{
    protected $message = 'An error occurred when trying to update a number preference.';
}
