<?php

namespace App\Exceptions;

use Exception;

class CustomerCreatedException extends Exception
{
    protected $message = 'An error occurred when trying to register a customer.';
}
