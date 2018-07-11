<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\Message\AbstractResponse;
/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class CompletePurchaseResponse extends AbstractResponse
{
    const SUCCESSFUL_STATUS = "COMPLETED";
    const PAYMENT_ID_PROPERTY_NAME = "PAYMENT_ID";

    /**
     * @return array
     */
    public function getOrder()
    {
        return $this->data['orders'][0] ?? [];
    }
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->getOrder()['status'] == static::SUCCESSFUL_STATUS;
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
}
