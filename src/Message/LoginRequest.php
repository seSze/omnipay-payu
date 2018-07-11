<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\PayU\Endpoint;
use Omnipay\PayU\HasCredentials;
/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class LoginRequest extends AbstractRequest
{
    use HasCredentials;

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
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
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $request = $this->httpClient->post($this->getEndpoint());
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 6);
        $response = $request->send();

        return new LoginResponse($this, json_decode((string)$response->getBody(), true));
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

        $endpoint = new Endpoint(true);

        return $endpoint->get($this->getTestMode()) .'?'.http_build_query($credentials);
    }
}
