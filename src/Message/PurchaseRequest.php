<?php

namespace Omnipay\Mpgs\Message;

/**
 * Mpgs Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    protected $operation = 'PURCHASE';

    protected $action = 'session';

    public function getData()
    {
        $this->validate('currency', 'amount', 'returnUrl', 'transactionId');

        return array_merge($this->getBaseData(), [
            'apiOperation' => 'INITIATE_CHECKOUT',
            'order' => [
                'id' => $this->getTransactionId(),
                'amount' => $this->getAmount(),
                'currency' => $this->getCurrency(),
                'description' => "Paying for the order - {$this->getTransactionReference()}",
                'reference' => $this->getTransactionReference(),
                'invoiceNumber' => $this->getTransactionReference(),
                'notificationUrl' => $this->getNotifyUrl(),
            ],
            'customer' => [
                'email' => $this->getCard()->getEmail(),
                'mobilePhone' => $this->getCard()->getBillingPhone(),
                'firstName' => $this->getCard()->getFirstName(),
                'lastName' => $this->getCard()->getLastName(),
            ],
            'billing' => [
                'address' => [
                    'city' => $this->getCard()->getBillingCity(),
                    'country' => $this->getCard()->getBillingCountry(),
                    'postcodeZip' => $this->getCard()->getBillingPostcode(),
                    'stateProvince' => $this->getCard()->getBillingState(),
                    'street' => $this->getCard()->getBillingAddress1(),
                    'street2' => $this->getCard()->getBillingAddress2(),
                ],
            ],
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

        $httpResponse = $this->httpClient->request('POST', $this->getEndpoint(), $this->getHeaders(), json_encode($data));

        $body = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new Response($this, $body, $httpResponse);
    }
}
