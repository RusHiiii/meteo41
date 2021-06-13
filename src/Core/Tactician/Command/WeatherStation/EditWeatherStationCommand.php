<?php

namespace App\Core\Tactician\Command\WeatherStation;

class EditWeatherStationCommand extends RegisterWeatherStationCommand
{
    private int $id;

    /**
     * EditWeatherStationCommand constructor.
     * @param string $name
     * @param string $description
     * @param string $shortDescription
     * @param string $country
     * @param string $address
     * @param string $city
     * @param float $lat
     * @param float $lng
     * @param string|null $apiToken
     * @param string $model
     * @param string $elevation
     * @param string $reference
     */
    public function __construct(
        string $name,
        string $description,
        string $shortDescription,
        string $country,
        string $address,
        string $city,
        float $lat,
        float $lng,
        string $model,
        string $elevation,
        string $reference,
        ?string $apiToken = null
    ) {
        parent::__construct($name, $description, $shortDescription, $country, $address, $city, $lat, $lng, $apiToken, $model, $elevation, $reference);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
