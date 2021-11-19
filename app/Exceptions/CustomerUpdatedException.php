<?php

namespace App\Exceptions;

use Exception;

class CustomerUpdatedException extends Exception
{
    protected $message = 'An error occurred when trying to update a customer.';
}
