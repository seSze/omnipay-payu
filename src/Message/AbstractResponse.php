<?php

namespace Omnipay\PayU\Message;

use Omnipay\Common\Message\AbstractResponse as BaseResponse;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
abstract class AbstractResponse extends BaseResponse
{
    const SUCCESS_STATUS_CODE = "SUCCESS";
    /**
     * @param string|null $key
     * @return array|string
     */
    public function getData(string $key = null)
    {
        $data = parent::getData();
        if (!empty($key)) {
            return $data[$key] ?? '';
        }

        return $data;
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->data['status']['code'] == static::SUCCESS_STATUS_CODE;
    }
}
