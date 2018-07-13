<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\Message\ResponseInterface;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class LoginRequest extends AbstractRequest
{
    /**
     * @var bool
     */
    protected $isAuthRequest = true;

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('oauthClientId', 'oauthClientSecret');

        return [];
    }

    /**
     * Send the request with specified data
     *
     * @param  array $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $response = $this->httpClient->request('POST', $this->getEndpoint());

        return new LoginResponse($this, $this->getResponseData($response));
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        $credentials = [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->getOauthClientId(),
            'client_secret' => $this->getOauthClientSecret(),
        ];

        return $this->endpoint->get($this->getTestMode()).'?'.http_build_query($credentials);
    }
}
