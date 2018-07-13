<?php

namespace Omnipay\PayU\Exceptions;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class MethodNotSupportedException extends \LogicException
{
    const MESSAGE = "Method %s is not supported by this Gateway";

    /**
     * @param string $methodName
     */
    public function __construct(string $methodName)
    {
        parent::__construct(sprintf(static::MESSAGE, $methodName));
    }
}
