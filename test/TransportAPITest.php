<?php
namespace CABDesigns\AlexaNextBus\Test;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;
use CABDesigns\AlexaNextBus\TransportAPI;

class TransportAPITest extends TestCase {

    public function testFetchNextBusesReturnsPromises() {
        $client = $this->getMockBuilder(ClientInterface::class)->getMock();
        $client->expects($this->any())
            ->method('requestAsync')
            ->with($this->equalTo('GET'), "https://transportapi.com/v3/uk/bus/stop/123/live.json?app_id=exampleId&app_key=exampleKey&group=route&nextbuses=yes")
            ->willReturn($this->getMockBuilder(PromiseInterface::class)->getMock());
        $api = new TransportAPI($client, 'exampleId', 'exampleKey');

        $promises = $api->fetchNextBuses(['123']);

        $this->assertInstanceOf(PromiseInterface::class, $promises[0]);
    }
}