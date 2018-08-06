<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\Message\ResponseInterface;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('currency', 'amount');
        $items = [];
        foreach ($this->getItems() as $item) {
            $items[] = [
                'name'      => $item->getName(),
                'unitPrice' => $item->getPrice(),
                'quantity'  => $item->getQuantity(),
            ];
        }

        $data = [
            'continueUrl'   => $this->getReturnUrl(),
            'notifyUrl'     => $this->getNotifyUrl(),
            'totalAmount'   => $this->getAmountInteger(),
            'customerIp'    => $this->getClientIp(),
            'description'   => $this->getDescription(),
            'currencyCode'  => $this->getCurrency(),
            'products'      => $items,
            'merchantPosId' => $this->getMerchantId(),
        ];

        if ($this->getOrderId()) {
            $data['extOrderId'] = $this->getOrderId();
        }

        if ($buyer = $this->getBuyer()) {
            $data['buyer'] = $buyer;
        }

        return $data;
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
        $response = $this->request('POST', $data);

        return new PurchaseResponse($this, json_decode($response->getBody()->getContents(), true));
    }

    /**
     * @param array $buyer
     *
     * @return AbstractRequest
     */
    public function setBuyer(array $buyer)
    {
        return $this->setParameter('buyer', $buyer);
    }

    /**
     * @return mixed
     */
    public function getBuyer()
    {
        return $this->getParameter('buyer');
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        $ip = parent::getClientIp();
        if (!empty($ip)) {
            return $ip;
        }
        if (function_exists('request')) {
            return request()->getClientIp();
        }

        return '';
    }

    /**
     * @param $orderId
     *
     * @return AbstractRequest
     */
    public function setOrderId($orderId)
    {
        return $this->setParameter('orderId', $orderId);
    }

    /**
     * @return string|int
     */
    public function getOrderId()
    {
        return $this->getParameter('orderId') ."-".str_random(10);
    }
}
