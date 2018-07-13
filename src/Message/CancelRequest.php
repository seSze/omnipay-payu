<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\Message\ResponseInterface;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class CancelRequest extends AbstractRequest
{
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
        $response = $this->request('DELETE');

        return new CancelResponse($this, $this->getResponseData($response));
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint().$this->getOrderId();
    }
}
