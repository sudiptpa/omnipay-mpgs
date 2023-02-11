<?php

namespace Omnipay\Mpgs\Message;

/**
 * Class PurchaseResponse.
 */
class PurchaseResponse extends \Omnipay\Mpgs\Message\AbstractResponse
{
    public function isSuccessful()
    {
        $statusCode = $this->getStatusCode();

        return $statusCode >= 200 && $statusCode <= 399;
    }

    public function getSuccessIndicator()
    {
        return isset($this->data['successIndicator']) ? $this->data['successIndicator'] : null;
    }

    public function getSessionId()
    {
        return isset($this->data['session']['id']) ? $this->data['session']['id'] : null;
    }
}
