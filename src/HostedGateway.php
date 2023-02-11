<?php

namespace Omnipay\Mpgs;

use Omnipay\Common\AbstractGateway;

/**
 * MPGS Gateway
 *
 * @link https://na-gateway.mastercard.com/api/documentation/integrationGuidelines/index.html
 */
class HostedGateway extends AbstractGateway
{
    public function getName()
    {
        return 'MPGS';
    }

    public function getDefaultParameters()
    {
        return [
            'merchantId' => '',
            'apiUsername' => '',
            'apiPassword' => '',
        ];
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getApiUsername()
    {
        if ($this->getParameter('apiUsername')) {
            return $this->getParameter('apiUsername');
        }

        return "merchant.{$this->getMerchantId()}";
    }

    public function setApiUsername($value)
    {
        return $this->setParameter('apiUsername', $value);
    }

    public function getApiPassword()
    {
        return $this->getParameter('apiPassword');
    }

    public function setApiPassword($value)
    {
        return $this->setParameter('apiPassword', $value);
    }

    public function getApiUrlPrefix()
    {
        return $this->getParameter('apiUrlPrefix');
    }

    public function setApiUrlPrefix($value)
    {
        return $this->setParameter('apiUrlPrefix', $value);
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Mpgs\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Mpgs\Message\CompletePurchaseRequest', $parameters);
    }

    public function checkGateway(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Mpgs\Message\CheckGatewayRequest', $parameters);
    }
}
