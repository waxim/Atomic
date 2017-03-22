<?php

namespace Atomic\Exceptions;

class CallbackCantBeCalled extends \Exception
{
    protected $message = 'The callback was not a valid function.';
}
