<?php

namespace Omnipay\Mpgs\Message;

use Omnipay\Common\Message\RequestInterface;

/**
 * Class PurchaseResponse.
 */
class PurchaseResponse extends \Omnipay\Common\Message\AbstractResponse
{
    public function isSuccessful()
    {
        $statusCode = $this->getStatusCode();

        return $statusCode >= 200 && $statusCode <= 399;
    }
}
