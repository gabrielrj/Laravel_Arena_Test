<?php

namespace App\Exceptions;

use Exception;

class NumberPreferencesNotFoundException extends Exception
{
    protected $message = 'Number preference not found.';
}
