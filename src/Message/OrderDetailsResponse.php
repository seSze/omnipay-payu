<?php

namespace Omnipay\PayU\Message;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class OrderDetailsResponse extends AbstractResponse
{
    const PAYMENT_ID_PROPERTY_NAME = "PAYMENT_ID";

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->getOrderData('orderId');
    }

    /**
     * @return string
     */
    public function getExtOrderId()
    {
        return $this->getExtOrderIdFromString(
            $this->getOrderData('extOrderId')
        );
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return new \DateTime($this->getOrderData('orderCreateDate'));
    }

    /**
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->getOrderData('notifyUrl');
    }

    /**
     * @return string
     */
    public function getCustomerIp()
    {
        return $this->getOrderData('customerIp');
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->getOrderData('currencyCode');
    }

    /**
     * @return string
     */
    public function getTotalAmount()
    {
        return $this->getOrderData('totalAmount');
    }

    /**
     * @return array
     */
    public function getBuyer()
    {
        return $this->getOrderData('buyer');
    }

    /**
     * @return string
     */
    public function getPayMethod()
    {
        return $this->getOrderData('payMethod')['type'] ?? '';
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->getOrderData('status');
    }

    public function isNew()
    {
        return $this->getStatus() == "NEW";
    }

    /**
     * @return string|array
     */
    public function getProducts()
    {
        return $this->getOrderData('products');
    }

    /**
     * @return string
     */
    public function getPaymentId()
    {
        $paymentData = array_shift(array_filter($this->getProperties(), function ($item) {
            return $item['name'] == static::PAYMENT_ID_PROPERTY_NAME;
        }));

        return $paymentData['value'] ?? '';
    }

    /**
     * @return array|string
     */
    public function getProperties()
    {
        return $this->getData('properties');
    }

    /**
     * @param string|null $key
     * @return string|array
     */
    public function getOrderData(string $key = null)
    {
        $data = $this->getData();

        $order = array_shift($data['orders']);

        if (!empty($key)) {
            return $order[$key] ?? '';
        }

        return $order;
    }
}
