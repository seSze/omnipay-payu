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
class PurchaseRequest extends AbstractRequest
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
            'continueUrl'   => $this->getContinueUrl(),
            'notifyUrl'     => $this->getNotifyUrl(),
            'totalAmount'   => $this->getIntegerAmount() ?: $this->getAmountInteger(),
            'customerIp'    => $this->getClientIp(),
            'extOrderId'    => $this->getOrderId(),
            'description'   => $this->getDescription(),
            'currencyCode'  => $this->getCurrency(),
            'products'      => $items,
//            'buyer'         => $this->getBuyer(),
            'merchantPosId' => $this->getMerchantId(),
        ];


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
        // Guzzle 3 does not support passing headers and response has encoding text/html
        $accessToken = $this->getParameter('accessToken');
        $ch          = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->getEndpoint());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                "Content-Type: application/json",
                "Authorization: Bearer $accessToken",
            ]
        );

        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);

        return new PurchaseResponse($this, $response);
    }


    /**
     * @param bool $oauth
     *
     * @return string
     */
    public function getEndpoint(bool $oauth = false)
    {
        $endpoint = new Endpoint($oauth);

        return $endpoint->get($this->getTestMode());
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
     * @return mixed
     */
    public function getContinueUrl()
    {
        return $this->getParameter('continueUrl');
    }

    /**
     * @param $url
     *
     * @return AbstractRequest
     */
    public function setContinueUrl($url)
    {
        return $this->setParameter('continueUrl', $url);
    }

    /**
     * @return mixed|string
     */
    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    /**
     * @param string $amount
     *
     * @return AbstractRequest
     */
    public function setAmount($amount)
    {
        return $this->setParameter('amount', $amount);
    }

    /**
     * @param $amount
     *
     * @return AbstractRequest
     */
    public function setIntegerAmount($amount)
    {
        return $this->setParameter('integerAmount', $amount);
    }

    /**
     * @return mixed
     */
    public function getIntegerAmount()
    {
        return $this->getParameter('integerAmount');
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
     * @return string
     */
    public function getClientIp()
    {
        return $this->getParameter('ip') ?: request()->getClientIp() ?? '';
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }
}
