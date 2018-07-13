<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\Message\ResponseInterface;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('orderId');

        return [
            'refund'  => [
                'description' => $this->getDescription(),
                'amount'      => $this->getAmount(),
            ],
            'orderId' => $this->getOrderId(),
        ];
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $response = $this->request('POST', $data);

        return new RefundResponse($this, $this->getResponseData($response));
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return parent::getEndpoint().$this->getOrderId().'/refund';
    }
}
