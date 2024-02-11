<?php

namespace App\Core\Tactician\Command\WeatherStation;

class RegisterWeatherStationCommand
{
    private string $name;

    private string $description;

    private string $shortDescription;

    private string $country;

    private string $address;

    private string $city;

    private string $postalCode;

    private float $lat;

    private float $lng;

    private ?string $apiToken;

    private string $model;

    private string $reference;

    private string $elevation;

    private ?string $preferedUnit;

    /**
     * RegisterWeatherStationCommand constructor.
     * @param string $name
     * @param string $description
     * @param string $shortDescription
     * @param string $country
     * @param string $address
     * @param string $city
     * @param string $postalCode
     * @param float $lat
     * @param float $lng
     * @param string|null $apiToken
     * @param string $model
     * @param string $elevation
     * @param string $reference
     * @param string|null $preferedUnit
     */
    public function __construct(
        string $name,
        string $description,
        string $shortDescription,
        string $country,
        string $address,
        string $city,
        string $postalCode,
        float $lat,
        float $lng,
        ?string $apiToken,
        string $model,
        string $elevation,
        string $reference,
        ?string $preferedUnit = null
    ) {
        $this->name = $name;
        $this->postalCode = $postalCode;
        $this->description = $description;
        $this->shortDescription = $shortDescription;
        $this->country = $country;
        $this->address = $address;
        $this->city = $city;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->apiToken = $apiToken;
        $this->model = $model;
        $this->reference = $reference;
        $this->elevation = $elevation;
        $this->preferedUnit = $preferedUnit;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLng(): float
    {
        return $this->lng;
    }

    /**
     * @return string|null
     */
    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getElevation(): string
    {
        return $this->elevation;
    }

    /**
     * @return string|null
     */
    public function getPreferedUnit(): ?string
    {
        return $this->preferedUnit;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }
}
