<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\Message\ResponseInterface;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class OrderDetailsRequest extends AbstractRequest
{
    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
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
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $response = $this->request('GET');

        return new OrderDetailsResponse($this, $this->getResponseData($response));
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint().$this->getOrderId();
    }
}
