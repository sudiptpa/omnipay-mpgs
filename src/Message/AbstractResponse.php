<?php

namespace Omnipay\Mpgs\Message;

use Omnipay\Common\Message\RequestInterface;

/**
 * Class AbstractResponse.
 */
class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    /**
     * @param RequestInterface $request
     * @param $data
     * @param $headers
     * @param $status
     */
    public function __construct(RequestInterface $request, $data, $headers, $status)
    {
        $this->request = $request;
        $this->data = $data;
        $this->headers = $headers;
        $this->status = $status;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getStatusCode()
    {
        return $this->status;
    }

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return false;
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
}
