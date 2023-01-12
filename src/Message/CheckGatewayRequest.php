<?php

namespace Omnipay\Mpgs\Message;

/**
 * Mpgs Check Gateway Request
 */
class CheckGatewayRequest extends AbstractRequest
{
    public function getData()
    {
        return [];
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request('GET', $this->getEndpoint());

        $body = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->createResponse($body, $httpResponse->getHeaders(), $httpResponse->getStatusCode());
    }

    public function getEndpoint()
    {
        return parent::getApiUrlPrefix() . "/api/rest/version/{$this->apiVersion}/information";
    }
}
