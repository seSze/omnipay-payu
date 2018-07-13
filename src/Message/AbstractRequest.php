<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\Http\ClientInterface;
use Omnipay\Common\Message\AbstractRequest as BaseRequest;
use Omnipay\PayU\Endpoint;
use Omnipay\PayU\HasCredentials;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
abstract class AbstractRequest extends BaseRequest
{
    use HasCredentials;

    /**
     * @var bool
     */
    protected $isAuthRequest = false;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @param ClientInterface $httpClient
     * @param HttpRequest     $httpRequest
     */
    public function __construct(ClientInterface $httpClient, HttpRequest $httpRequest)
    {
        $this->endpoint = (new Endpoint($this->isAuthRequest));
        parent::__construct($httpClient, $httpRequest);
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint->get($this->getTestMode());
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     */
    public function getData()
    {
        return [];
    }

    /**
     * @param string $method
     * @param array  $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request(string $method, $data = [])
    {
        return $this->httpClient->request($method, $this->getEndpoint(), [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '.$this->getAccessToken(),
        ], json_encode($data));
    }

    /**
     * @param string|int $orderId
     * @return OrderDetailsRequest
     */
    public function setOrderId($orderId)
    {
        return $this->setParameter('orderId', $orderId);
    }

    /**
     * @return string|null
     */
    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    /**
     * @param $response
     * @return array
     */
    public function getResponseData($response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
