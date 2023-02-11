<?php

namespace Omnipay\Mpgs\Message;

use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{
    public function setUp(): void
    {
        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'merchantId' => '20230211',
            'apiPassword' => 'V6Vjb5y6Rmvq',
            'orderId' => '3451-5454545-5454-8766',
        ]);
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('CompletePurchaseRequestSuccess.txt');

        $response = $this->request->send();

        $data = $response->getData();

        $this->assertIsArray($data);

        $this->assertInstanceOf('\Omnipay\Mpgs\Message\CompletePurchaseResponse', $response);

        $this->assertFalse($response->isRedirect());
        $this->assertSame($response->getMessage(), 'SUCCESS');
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isCaptured());
        $this->assertSame($response->getOrderId(), '3451-5454545-5454-8766');
        $this->assertSame($response->getOrderStatus(), 'CAPTURED');
        $this->assertSame($response->getOrderReference(), 'B342A0671');
        $this->assertSame($data['totalAuthorizedAmount'], 555.26);
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('CompletePurchaseRequestFailure.txt');

        $response = $this->request->send();

        $data = $response->getData();

        $this->assertIsArray($data);

        $this->assertInstanceOf('\Omnipay\Mpgs\Message\CompletePurchaseResponse', $response);

        $this->assertSame($response->getStatusCode(), 400);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame($response->getMessage(), 'ERROR');
        $this->assertSame($data['error']['cause'], 'INVALID_REQUEST');
        $this->assertSame($data['error']['explanation'], 'Unable to find order 3451-5454545-5454-8766 for merchant 20230211');
    }
}
