<?php
namespace CABDesigns\AlexaNextBus;

use GuzzleHttp\ClientInterface;

class TransportAPI
{
    const HOST = 'https://transportapi.com';
    const BASE_PATH = '/v3/uk/bus/stop/';

    /** @var ClientInterface  */
    protected $client;

    /** @var string  */
    protected $appId;

    /** @var string  */
    protected $appKey;

    /**
     * TransportAPI constructor.
     * @param ClientInterface $client
     * @param string $appId
     * @param string $appKey
     */
    public function __construct(ClientInterface $client, string $appId, string $appKey)
    {
        $this->client = $client;
        $this->appId = $appId;
        $this->appKey = $appKey;
    }

    /**
     * @param array $atcoCodes
     * @return array
     */
    public function fetchNextBuses(array $atcoCodes): array
    {
        $promises = [];

        foreach ($atcoCodes as $atcoCode) {
            $promises[] = $this->client->requestAsync(
                'GET',
                $this->buildPath($atcoCode)
            );
        }

        return $promises;
    }

    /**
     * @param string $atcoCode
     * @return string
     */
    protected function buildPath(string $atcoCode): string
    {
        return sprintf(
            "%s%s%s/live.json?app_id=%s&app_key=%s&group=route&nextbuses=yes",
            self::HOST,
            self::BASE_PATH,
            $atcoCode,
            $this->appId,
            $this->appKey
        );
    }
}