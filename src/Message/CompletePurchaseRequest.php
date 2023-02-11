<?php

namespace Omnipay\Mpgs\Message;

/**
 * CompletePurchaseRequest
 * @link https://na-gateway.mastercard.com/api/documentation/apiDocumentation/rest-json/version/latest/operation/Transaction%3a%20%20Verify.html?locale=en_US
 */
class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('orderId');

        return [];
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request('GET', $this->getEndpoint(), $this->getHeaders(), json_encode($data));

        $body = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->createResponse($body, $httpResponse->getHeaders(), $httpResponse->getStatusCode());
    }

    public function createResponse($data, $headers = [], $status = 404)
    {
        return $this->response = new CompletePurchaseResponse($this, $data, $headers, $status);
    }

    public function getEndpoint()
    {
        return parent::getApiBaseUrl() . "/order/{$this->getOrderId()}";
    }
}
