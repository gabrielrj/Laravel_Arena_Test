<?php

namespace App\Exceptions;

use Exception;

class NumberDeletedException extends Exception
{
    protected $message = 'An error occurred when trying to delete a number.';
}
