<?php

namespace Omnipay\PayU\Message;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class CancelResponse extends AbstractResponse
{
    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->getData('orderId');
    }

    /**
     * @return string
     */
    public function getExtOrderId()
    {
        return $this->getExtOrderIdFromString(
            $this->getData('extOrderId')
        );
    }
}
