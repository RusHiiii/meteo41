<?php

namespace App\Entity\Core\ViewModels\Observation;

class ObservationSearchView
{
    private int $numberOfResult;

    private array $observations;

    /**
     * ObservationSearchView constructor.
     * @param int $numberOfResult
     * @param array $observations
     */
    public function __construct(int $numberOfResult, array $observations)
    {
        $this->numberOfResult = $numberOfResult;
        $this->observations = $observations;
    }

    /**
     * @return int
     */
    public function getNumberOfResult(): int
    {
        return $this->numberOfResult;
    }

    /**
     * @return array
     */
    public function getObservations(): array
    {
        return $this->observations;
    }
}
