<?php

namespace Omnipay\PayU\Message;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class RefundResponse extends AbstractResponse
{
    /**
     * @return array|string
     */
    public function getOrderId()
    {
        return $this->getData('orderId');
    }

    /**
     * @return array|string
     */
    public function getRefundId()
    {
        return $this->getRefundData('refundId');
    }

    /**
     * @return array|string
     */
    public function getExtRefundId()
    {
        return $this->getRefundData('extRefundId');
    }

    /**
     * @return array|string
     */
    public function getAmount()
    {
        return $this->getRefundData('amount');
    }

    /**
     * @return array|string
     */
    public function getCurrencyCode()
    {
        return $this->getRefundData('currencyCode');
    }

    /**
     * @return array|string
     */
    public function getDescription()
    {
        return $this->getRefundData('description');
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return new \DateTime($this->getRefundData('creationDateTime'));
    }

    /**
     * @return array|string
     */
    public function getStatus()
    {
        return $this->getRefundData('status');
    }

    /**
     * @return \DateTime
     */
    public function getStatusData()
    {
        return new \DateTime($this->getRefundData('statusDateTime'));
    }

    /**
     * @param string|null $key
     * @return array|string
     */
    public function getRefundData(string $key = null)
    {
        $refund = $this->getData('refund');

        if (!empty($key)) {
            return $refund[$key] ?? '';
        }

        return $refund;
    }
}
