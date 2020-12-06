<?php


namespace App\Entity\WebApp;


use Doctrine\Common\Collections\ArrayCollection;

class WeatherStation
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

    private string $apiToken;

    private string $model;

    private string $elevation;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    private ArrayCollection $observations;

    /**
     * WeatherStation constructor.
     * @param string $name
     * @param string $description
     * @param string $shortDescription
     * @param string $country
     * @param string $address
     * @param string $city
     * @param float $lat
     * @param float $lng
     * @param string $apiToken
     * @param string $model
     * @param string $elevation
     */
    public function __construct(string $name, string $description, string $shortDescription, string $country, string $address, string $city, float $lat, float $lng, string $apiToken, string $model, string $elevation)
    {
        $this->name = $name;
        $this->description = $description;
        $this->shortDescription = $shortDescription;
        $this->country = $country;
        $this->address = $address;
        $this->city = $city;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->apiToken = $apiToken;
        $this->model = $model;
        $this->elevation = $elevation;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->observations = new ArrayCollection();
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
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     */
    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat(float $lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return float
     */
    public function getLng(): float
    {
        return $this->lng;
    }

    /**
     * @param float $lng
     */
    public function setLng(float $lng): void
    {
        $this->lng = $lng;
    }

    /**
     * @return string
     */
    public function getApiToken(): string
    {
        return $this->apiToken;
    }

    /**
     * @param string $apiToken
     */
    public function setApiToken(string $apiToken): void
    {
        $this->apiToken = $apiToken;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getElevation(): string
    {
        return $this->elevation;
    }

    /**
     * @param string $elevation
     */
    public function setElevation(string $elevation): void
    {
        $this->elevation = $elevation;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return ArrayCollection
     */
    public function getObservations(): ArrayCollection
    {
        return $this->observations;
    }

    /**
     * @param ArrayCollection $observations
     */
    public function setObservations(ArrayCollection $observations): void
    {
        $this->observations = $observations;
    }

    /**
     * @param Observation $observation
     * @return $this
     */
    public function addObservation(Observation $observation)
    {
        if (!$this->observations->contains($observation)) {
            $this->observations[] = $observation;
            $observation->setWeatherStation($this);
        }

        return $this;
    }

    /**
     * @param Observation $observation
     * @return $this
     */
    public function removeObservation(Observation $observation): self
    {
        if ($this->observations->contains($observation)) {
            $this->observations->removeElement($observation);

            if ($observation->getWeatherStation() === $this) {
                $observation->setWeatherStation(null);
            }
        }

        return $this;
    }
}