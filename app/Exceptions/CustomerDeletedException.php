<?php

namespace App\Exceptions;

use Exception;

class CustomerDeletedException extends Exception
{
    protected $message = 'An error occurred when trying to delete a customer.';
}
