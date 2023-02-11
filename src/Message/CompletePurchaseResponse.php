<?php

namespace Omnipay\Mpgs\Message;

/**
 * Class CompletePurchaseResponse.
 */
class CompletePurchaseResponse extends \Omnipay\Mpgs\Message\AbstractResponse
{
    public function isSuccessful()
    {
        $statusCode = $this->getStatusCode();

        return $statusCode >= 200 && $statusCode <= 399;
    }

    public function getOrderId()
    {
        return isset($this->data['id']) ? $this->data['id'] : null;
    }

    public function getOrderStatus()
    {
        return isset($this->data['status']) ? $this->data['status'] : null;
    }

    public function getOrderReference()
    {
        return isset($this->data['reference']) ? $this->data['reference'] : null;
    }

    public function isCaptured()
    {
        return in_array($this->getOrderStatus(), ['CAPTURED']);
    }
}
