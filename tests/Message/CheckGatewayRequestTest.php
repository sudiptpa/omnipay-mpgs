<?php

namespace Omnipay\Mpgs\Message;

use Omnipay\Tests\TestCase;

class CheckGatewayRequestTest extends TestCase
{
    public function setUp(): void
    {
        $this->request = new CheckGatewayRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'apiUrlPrefix' => 'https://na-gateway.mastercard.com',
            'merchantId' => 'TESTING123',
            'apiPassword' => 'PW654321',
        ]);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CheckGatewaySuccess.txt');

        $response = $this->request->send();
        $data = $response->getData();

        $this->assertIsArray($data);
        $this->assertInstanceOf('\Omnipay\Mpgs\Message\AbstractResponse', $response);
        $this->assertEquals($data['gatewayVersion'], '22.8.0.2-1R');
        $this->assertEquals($data['status'], 'OPERATING');

        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('CheckGatewayFailure.txt');

        $response = $this->request->send();

        $this->assertSame($response->getStatusCode(), 404);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('ERROR', $response->getMessage());
    }
}
