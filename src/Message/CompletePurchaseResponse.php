<?php

namespace Omnipay\Mpgs\Message;

use Omnipay\Common\Message\RequestInterface;

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
}
