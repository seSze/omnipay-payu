<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\Message\AbstractResponse;
/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class LoginResponse extends AbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return !!$this->data['access_token'];
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->data['access_token'] ?? '';
    }

    /**
     * @return string
     */
    public function getExpiresIn(): string
    {
       return $this->data['expires_in'] ?? '';
    }
}
