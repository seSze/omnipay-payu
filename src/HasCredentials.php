<?php

namespace Omnipay\PayU;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
trait HasCredentials
{
    public function setAccessToken($accessToken)
    {
        return $this->setParameter('accessToken', $accessToken);
    }

    public function getAccessToken()
    {
        return $this->getParameter('accessToken');
    }
    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param $merchantId
     *
     * @return mixed
     */
    public function setMerchantId($merchantId)
    {
        return $this->setParameter('merchantId', $merchantId);
    }

    /**
     * @return mixed
     */
    public function getMerchantSecret()
    {
        return $this->getParameter('merchantSecret');
    }

    /**
     * @param $merchantSecret
     */
    public function setMerchantSecret($merchantSecret)
    {
        $this->setParameter('merchantSecret', $merchantSecret);
    }

    /**
     * @return mixed
     */
    public function getOauthClientId()
    {
        return $this->getParameter('oauthClientId');
    }

    /**
     * @param $oauthClientId
     *
     * @return mixed
     */
    public function setOauthClientId($oauthClientId)
    {
        return $this->setParameter('oauthClientId', $oauthClientId);
    }

    /**
     * @return mixed
     */
    public function getOauthClientSecret()
    {
        return $this->getParameter('oauthClientSecret');
    }

    /**
     * @param $oauthClientSecret
     *
     * @return mixed
     */
    public function setOauthClientSecret($oauthClientSecret)
    {
        return $this->setParameter('oauthClientSecret', $oauthClientSecret);
    }
}