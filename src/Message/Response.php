<?php

namespace Omnipay\Mpgs\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Mpgs Response
 */
class Response extends AbstractResponse
{
    /**
     * The Guzzle response object.
     */
    protected $guzzle_response;

    /**
     * @param RequestInterface $request
     * @param $data
     * @param $response
     */
    public function __construct(RequestInterface $request, $data, $response)
    {
        if (!is_array($data)) {
            parse_str($data, $data);
        }

        parent::__construct($request, $data);

        $this->guzzle_response = $response;
    }

    public function isSuccessful()
    {
        return $this->guzzle_response && $this->guzzle_response->isSuccessful();
    }

    public function getStatusCode()
    {
        return $this->guzzle_response && $this->guzzle_response->getStatusCode();
    }

    public function getMessage()
    {
        return isset($this->data['result']) ? $this->data['result'] : null;
    }

    public function isMessageSuccess()
    {
        return $this->getMessage() == 'SUCCESS';
    }

    public function getSuccessIndicator()
    {
        return isset($this->data['successIndicator']) ? $this->data['successIndicator'] : null;
    }

    public function getSessionId()
    {
        return isset($this->data['session']['id']) ? $this->data['session']['id'] : null;
    }

    public function getOrderId()
    {
        return isset($this->data['order']['id']) ? $this->data['order']['id'] : null;
    }

    public function getTransactionId()
    {
        return isset($this->data['transaction']['id']) ? $this->data['transaction']['id'] : null;
    }

    public function getGatewayCode()
    {
        return isset($this->data['response']['gatewayCode']) ? $this->data['response']['gatewayCode'] : null;
    }
}
