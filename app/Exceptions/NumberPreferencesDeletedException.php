<?php

namespace App\Exceptions;

use Exception;

class NumberPreferencesDeletedException extends Exception
{
    protected $message = 'An error occurred when trying to delete a number preference.';
}
