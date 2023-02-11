<?php

namespace Omnipay\Mpgs\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function setUp(): void
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'merchantId' => '20230211',
            'apiPassword' => 'V6Vjb5y6Rmvq',
            'amount' => 10.00,
            'transactionId' => '1',
            'currency' => 'AUD',
            'card' => $this->getValidCard(),
            'returnUrl' => 'https://example.com/checkout/1/success',
        ]);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('PurchaseRequestSuccess.txt');

        $response = $this->request->send();

        $data = $response->getData();

        $this->assertIsArray($data);

        $this->assertInstanceOf('\Omnipay\Mpgs\Message\PurchaseResponse', $response);

        $this->assertEquals($data['checkoutMode'], 'WEBSITE');
        $this->assertEquals($data['merchant'], '20230211');

        $this->assertFalse($response->isRedirect());
        $this->assertSame($response->getMessage(), 'SUCCESS');
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame($response->getSuccessIndicator(), '4a0f35687c204nfb');
        $this->assertSame($response->getSessionId(), 'SESSION0002580462196G6604316I00');
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('PurchaseRequestFailure.txt');

        $response = $this->request->send();

        $data = $response->getData();

        $this->assertIsArray($data);

        $this->assertInstanceOf('\Omnipay\Mpgs\Message\PurchaseResponse', $response);

        $this->assertSame($response->getStatusCode(), 400);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame($response->getMessage(), 'ERROR');
    }
}
