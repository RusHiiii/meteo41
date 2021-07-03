<?php

namespace App\Core\ExternalApi;

use App\Core\Exception\ExternalApi\GeocodingException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Geocoding
{
    const URL = 'https://maps.googleapis.com/maps/api/geocode/json';
    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $geocodingKey;

    public function __construct(
        HttpClientInterface $client,
        string $geocodingKey
    ) {
        $this->client = $client;
        $this->geocodingKey = $geocodingKey;
    }

    /**
     * @param string $address
     * @return array
     * @throws GeocodingException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function fetchGeocoding(string $address)
    {
        try {
            $response = $this->client->request(
                'GET',
                self::URL,
                [
                    'query' => [
                        'address' => $address,
                        'language' => 'fr',
                        'region' => 'fr',
                        'key' => $this->geocodingKey
                    ]
                ]
            );
        } catch (\Exception $e) {
            throw new GeocodingException();
        }

        if ($response->getStatusCode() !== 200) {
            throw new GeocodingException();
        }

        return $response->toArray();
    }
}
