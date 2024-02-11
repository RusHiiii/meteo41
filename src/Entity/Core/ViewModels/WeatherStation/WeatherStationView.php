<?php

namespace App\Entity\Core\ViewModels\WeatherStation;

class WeatherStationView
{
    private int $id;

    private string $name;

    private string $description;

    private string $shortDescription;

    private string $country;

    private string $address;

    private string $city;

    private float $lat;

    private float $lng;

    private string $model;

    private string $elevation;

    private string $reference;

    private string $postalCode;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    /**
     * WeatherStationView constructor.
     * @param int $id
     * @param string $name
     * @param string $description
     * @param string $shortDescription
     * @param string $country
     * @param string $address
     * @param string $city
     * @param float $lat
     * @param float $lng
     * @param string $model
     * @param string $elevation
     * @param string $postalCode
     * @param string $reference
     */
    public function __construct(int $id, string $name, string $description, string $shortDescription, string $country, string $address, string $city, float $lat, float $lng, string $model, string $elevation, string $reference, string $postalCode, \DateTime $createdAt, \DateTime $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->shortDescription = $shortDescription;
        $this->country = $country;
        $this->address = $address;
        $this->city = $city;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->model = $model;
        $this->postalCode = $postalCode;
        $this->reference = $reference;
        $this->elevation = $elevation;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @return float
     */
    public function getLng(): float
    {
        return $this->lng;
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
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }
}
