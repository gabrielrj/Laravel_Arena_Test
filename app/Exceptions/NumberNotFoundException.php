<?php

namespace App\Exceptions;

use Exception;

class NumberNotFoundException extends Exception
{
    protected $message = 'Number not found.';
}
