<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Migs\Message\AbstractRequest;
use Omnipay\PayU\Endpoint;
use Omnipay\PayU\HasCredentials;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class CompletePurchaseRequest extends AbstractRequest
{
    use HasCredentials;

    // VJ61R1R8N2180711GUEST000P01

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('orderId');

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
        $request = $this->httpClient->get(
            $this->getEndpoint(),
            [
                'Authorization' => 'Bearer '.$this->getAccessToken(),
            ]
        );
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 6);

        $response = $request->send();

        return new CompletePurchaseResponse($this, json_decode((string)$response->getBody(), true));
    }

    /**
     * @param string $orderId
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setOrderId($orderId)
    {
        return $this->setParameter('orderId', $orderId);
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->getParameter('orderId');
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return (new Endpoint())->get($this->getTestMode()).$this->getOrderId();
    }
}
