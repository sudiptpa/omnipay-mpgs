<?php

namespace Omnipay\Mpgs\Message;

/**
 * Mpgs Check Gateway Request
 */
class CheckGatewayRequest extends AbstractRequest
{
    protected $action = 'information';

    public function getData()
    {
        return [];
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request('GET', $this->getEndpoint());

        $body = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new Response($this, $body, $httpResponse);
    }

    public function getEndpoint()
    {
        return vsprintf('%1$s/api/rest/version/%2$s/%3$s', [
            $this->getApiUrlPrefix(),
            $this->apiVersion,
            $this->action,
        ]);
    }
}
