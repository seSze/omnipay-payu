<?php

namespace Omnipay\PayU;

use GuzzleHttp\Client;
use Omnipay\Common\AbstractGateway;
use Omnipay\PayU\Message\PurchaseResponse;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface purchase(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = [])
 */
class Gateway extends AbstractGateway
{
    const NAME = 'PayU';
    const PRODUCTION_ENV = 'secure';
    const DEVELOPMENT_ENV = 'sandbox';
    protected $client;

    use HasCredentials;


    public function getDefaultParameters()
    {
        return [
            "merchantId"        => "",
            "merchantSecret"    => "",
            "oauthClientId"     => "",
            "oauthClientSecret" => "",
            
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

    public function __call($name, $arguments)
    {
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface purchase(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function login(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayU\Message\LoginRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function capture(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayU\Message\CaptureRequest', $parameters);
    }

    public function completePurchase(array $parameters = [])
    {
        return $this->guard()->createRequest('\Omnipay\PayU\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return PurchaseResponse
     */
    public function purchase(array $parameters = [])
    {
        return $this->guard()->createRequest('\Omnipay\PayU\Message\PurchaseRequest', $parameters);
    }

    public function guard()
    {
        if ($this->getParameter('accessToken')) {
            return $this;
        }

        $response = $this->login()->send();
        
        $this->setParameter('accessToken', $response->getAccessToken());

        return $this;
    }
}