<?php

namespace Omnipay\Mpgs\Message;

/**
 * CompletePurchaseRequest
 * @link https://na-gateway.mastercard.com/api/documentation/apiDocumentation/rest-json/version/latest/operation/Transaction%3a%20%20Verify.html?locale=en_US
 */
class CompletePurchaseRequest extends AbstractRequest
{
    protected $operation = 'VERIFY';

    public function getData()
    {
        $this->validate('currency', 'amount', 'returnUrl', 'transactionId');

        return array_merge($this->getBaseData(), [
            'order' => [
                'currency' => $this->getCurrency(),
            ]
        ]);
    }

    public function filterDataRecursively($array = [])
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = $this->filterDataRecursively($value);
            }
        }

        return array_filter($array);
    }

    public function sendData($data)
    {
        $data = $this->filterDataRecursively($data);

        $httpResponse = $this->httpClient->request('PUT', $this->getEndpoint(), $this->getHeaders(), json_encode($data));

        $body = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->createResponse($body, $httpResponse->getHeaders(), $httpResponse->getStatusCode());
    }

    public function createResponse($data, $headers = [], $status = 404)
    {
        return $this->response = new PurchaseResponse($this, $data, $headers, $status);
    }

    public function getEndpoint()
    {
        return parent::getApiBaseUrl() . "/order/{$this->getOrderId()}/transaction/{$this->getOrderTransactionId()}";
    }
}
