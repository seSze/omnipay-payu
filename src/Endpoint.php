<?php

namespace Omnipay\PayU;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class Endpoint
{
    const DOMAIN = 'payu.com';
    const URI = 'api/v2_1/orders/';

    const PREFIX = 'https://secure.';
    const OAUTH_CONTEXT = 'pl/standard/user/oauth/authorize';

    /**
     * @var bool
     */
    private $oauth;

    /**
     * @param bool   $oauth
     */
    public function __construct(bool $oauth = false)
    {
        $this->oauth = $oauth;
    }


    /**
     * @param bool $testMode
     *
     * @return string
     */
    public function get($testMode = false): string
    {
        if ($this->oauth) {
            return $this->buildUrl(static::OAUTH_CONTEXT, $testMode ? 'snd' : '');
        }

        return $this->buildUrl(static::URI, $testMode ? 'snd' : '');
    }

    /**
     * @param string $prefix
     * @param string $uri
     *
     * @return string
     */
    protected function buildUrl(string $uri, string $prefix): string
    {
        $domain = strtolower(rtrim(static::DOMAIN, '/')).'/';
        $prefix = $prefix ? rtrim($prefix, '.').'.' : '';

        return static::PREFIX.$prefix.$domain.$uri;
    }
}