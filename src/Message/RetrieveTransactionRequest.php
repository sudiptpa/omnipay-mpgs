<?php

namespace Omnipay\Mpgs\Message;

/**
 * RetrieveTransactionRequest
 *
 * @link https://na-gateway.mastercard.com/api/documentation/apiDocumentation/rest-json/version/69/operation/Transaction%3a%20%20Retrieve%20Transaction.html?locale=en_US
 */
class RetrieveTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('orderId', 'orderTransactionId');

        return [];
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request('GET', $this->getEndpoint(), $this->getHeaders());

        $body = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->createResponse($body, $httpResponse->getHeaders(), $httpResponse->getStatusCode());
    }

    public function getEndpoint()
    {
        return parent::getApiBaseUrl() . "/order/{$this->getOrderId()}/transaction/{$this->getOrderTransactionId()}";
    }

    public function createResponse($data, $headers = [], $status = 404)
    {
        return $this->response = new PurchaseResponse($this, $data, $headers, $status);
    }
}
