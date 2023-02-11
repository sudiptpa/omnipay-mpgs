<?php

namespace Omnipay\Mpgs\Message;

/**
 * Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $apiVersion = 69;

    protected $operation = '';

    protected $action = '';

    protected $gatewayUrl = 'https://na-gateway.mastercard.com';

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
        return $this->getParameter('apiUrlPrefix') ?: $this->gatewayUrl;
    }

    public function setApiUrlPrefix($value)
    {
        return $this->setParameter('apiUrlPrefix', $value);
    }

    public function getMerchantName()
    {
        return $this->getParameter('merchantName');
    }

    public function setMerchantName($value)
    {
        return $this->setParameter('merchantName', $value);
    }

    public function getMerchantAddressLine1()
    {
        return $this->getParameter('merchantAddressLine1');
    }

    public function setMerchantAddressLine1($value)
    {
        return $this->setParameter('merchantAddressLine1', $value);
    }

    public function getMerchantAddressLine2()
    {
        return $this->getParameter('merchantAddressLine2');
    }

    public function setMerchantAddressLine2($value)
    {
        return $this->setParameter('merchantAddressLine2', $value);
    }

    public function getMerchantUrl()
    {
        return $this->getParameter('merchantUrl');
    }

    public function setMerchantUrl($value)
    {
        return $this->setParameter('merchantUrl', $value);
    }

    public function getMerchantLogo()
    {
        return $this->getParameter('merchantLogo');
    }

    public function setMerchantLogo($value)
    {
        return $this->setParameter('merchantLogo', $value);
    }

    public function getMerchantEmail()
    {
        return $this->getParameter('merchantEmail');
    }

    public function setMerchantEmail($value)
    {
        return $this->setParameter('merchantEmail', $value);
    }

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    protected function getBaseData()
    {
        return [
            'interaction' => [
                'operation' => $this->operation,
                'merchant' => [
                    'address' => [
                        'line1' => $this->getMerchantAddressLine1(),
                        'line2' => $this->getMerchantAddressLine2(),
                    ],
                    'name' => $this->getMerchantName(),
                    'email' => $this->getMerchantEmail(),
                    'url' => $this->getMerchantUrl(),
                    'logo' => $this->getMerchantLogo(),
                ],
                'returnUrl' => $this->getReturnUrl(),
                'cancelUrl' => $this->getCancelUrl(),
                'timeoutUrl' => $this->getCancelUrl(),
            ],
        ];
    }

    public function getApiBaseUrl()
    {
        return $this->getApiUrlPrefix() . "/api/rest/version/" . $this->apiVersion . "/merchant/" . $this->getMerchantId();
    }

    public function getHeaders()
    {
        $authToken = base64_encode("{$this->getApiUsername()}:{$this->getApiPassword()}");

        return [
            'Content-Type' => 'application/json;charset=UTF-8',
            'Authorization' => "Basic {$authToken}",
        ];
    }

    public function getEndpoint()
    {
        return $this->getApiBaseUrl() . "/" . $this->action;
    }

    public function createResponse($data, $headers = [], $status = 404)
    {
        return $this->response = new AbstractResponse($this, $data, $headers, $status);
    }
}
