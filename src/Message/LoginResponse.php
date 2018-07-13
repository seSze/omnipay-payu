<?php

namespace Omnipay\PayU\Message;

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
        return !!$this->getAccessToken();
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->getData('access_token');
    }

    /**
     * @return string
     */
    public function getTokenType()
    {
        return $this->getData('token_type');
    }

    /**
     * @return string
     */
    public function getExpiresIn(): string
    {
        return $this->getData('expires_in');
    }
}
