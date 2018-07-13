<?php

namespace Omnipay\PayU;

use Omnipay\Common\AbstractGateway;
use Omnipay\PayU\Exceptions\MethodNotSupportedException;
use Omnipay\PayU\Message\CancelRequest;
use Omnipay\PayU\Message\CompletePurchaseRequest;
use Omnipay\PayU\Message\LoginRequest;
use Omnipay\PayU\Message\OrderDetailsRequest;
use Omnipay\PayU\Message\PurchaseRequest;
use Omnipay\PayU\Message\RefundRequest;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = [])
 */
class Gateway extends AbstractGateway
{
    const NAME = 'PayU';

    use HasCredentials;

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'merchantId'        => '',
            'merchantSecret'    => '',
            'oauthClientId'     => '',
            'oauthClientSecret' => '',
        ];
    }

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function login(array $parameters = [])
    {
        return $this->createRequest(LoginRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function completePurchase(array $parameters = [])
    {
        return $this->guard()->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->guard()->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function getOrderDetails(array $parameters = [])
    {
        return $this->guard()->createRequest(OrderDetailsRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function refund(array $parameters = [])
    {
        return $this->guard()->createRequest(RefundRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function cancel(array $parameters = [])
    {
        return $this->guard()->createRequest(CancelRequest::class, $parameters);
    }

    /**
     * @return Gateway $this
     */
    public function guard()
    {
        if ($this->getParameter('accessToken')) {
            return $this;
        }
        $response = $this->login()->send();

        $this->setParameter('accessToken', $response->getAccessToken());

        return $this;
    }

    /**
     * @param string $name
     * @param array  $arguments
     */
    public function __call(string $name, array $arguments)
    {
        throw new MethodNotSupportedException($name);
    }
}
