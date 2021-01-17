<?php

namespace App\Entity\Core\ViewModels\Unit;

class UnitSearchView
{
    private int $numberOfResult;

    private array $units;

    /**
     * UnitSearchView constructor.
     * @param int $numberOfResult
     * @param array $units
     */
    public function __construct(int $numberOfResult, array $units)
    {
        $this->numberOfResult = $numberOfResult;
        $this->units = $units;
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
    public function getUnits(): array
    {
        return $this->units;
    }
}
