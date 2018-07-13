<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * Gets the redirect target url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->getData('redirectUri');
    }

    /**
     * Get the required redirect method (either GET or POST).
     *
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * Gets the redirect form data array, if the redirect method is POST.
     *
     * @return array
     */
    public function getRedirectData()
    {
        return $this->getData();
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return false;
    }

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
        return $this->getData('extOrderId');
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        $status = $this->getData('status');

        if ($status) {
            return $status['code'];
        }

        return '';
    }
}
