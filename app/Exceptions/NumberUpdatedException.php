<?php

namespace App\Exceptions;

use Exception;

class NumberUpdatedException extends Exception
{
    protected $message = 'An error occurred when trying to update a number.';
}
