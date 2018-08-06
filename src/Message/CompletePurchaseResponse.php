<?php

namespace Omnipay\PayU\Message;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class CompletePurchaseResponse extends AbstractResponse
{
    const PAYMENT_ID_PROPERTY_NAME = "PAYMENT_ID";

    public function isNew()
    {
        return $this->data['orders'][0]['status'] == "NEW";
    }
    
    /**
     * @return array
     */
    public function getOrder()
    {
        return $this->data['orders'][0] ?? [];
    }


    /**
     * @return string
     */
    public function getPaymentId()
    {
        $data = array_filter($this->data['properties'], function ($item){
            return $item['name'] == static::PAYMENT_ID_PROPERTY_NAME;
        });

        return array_pop($data)['value'] ?? '';
    }

    /**
     * @return string
     */
    public function getExtOrderId()
    {
        return $this->getExtOrderIdFromString(
            $this->getOrder()['extOrderId'] ?? ''
        );
    }

    /**
     * @return string
     */
    public function getPayMethodType()
    {
        return $this->getOrder()['payMethod']['type'] ?? '';
    }

    /**
     * @return array
     */
    public function getData(string $key = null)
    {
        return $this->data;
    }
}
