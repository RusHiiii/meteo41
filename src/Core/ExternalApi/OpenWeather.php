<?php

namespace App\Core\ExternalApi;

use App\Core\Exception\ExternalApi\GeocodingException;
use App\Core\Exception\ExternalApi\OpenWeatherException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenWeather
{
    const URL = 'https://api.openweathermap.org/data/3.0/onecall';
    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $openWeatherKey;

    public function __construct(
        HttpClientInterface $client,
        string $openWeatherKey
    ) {
        $this->client = $client;
        $this->openWeatherKey = $openWeatherKey;
    }

    /**
     * @param string $lat
     * @param string $lng
     * @return array
     * @throws OpenWeatherException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function fetchOpenWeather(string $lat, string $lng)
    {
        try {
            $response = $this->client->request(
                'GET',
                self::URL,
                [
                    'query' => [
                        'lat' => $lat,
                        'lon' => $lng,
                        'exclude' => 'hourly,minutely',
                        'appid' => $this->openWeatherKey,
                        'units' => 'metric',
                        'lang' => 'fr'
                    ]
                ]
            );
        } catch (\Exception $e) {
            throw new OpenWeatherException();
        }

        if ($response->getStatusCode() !== 200) {
            throw new OpenWeatherException();
        }

        return $response->toArray();
    }
}
