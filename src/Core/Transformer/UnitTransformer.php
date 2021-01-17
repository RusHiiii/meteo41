<?php

namespace App\Core\Transformer;

use App\Entity\Core\ViewModels\Unit\UnitSearchView;
use App\Entity\Core\ViewModels\Unit\UnitView;
use App\Entity\WebApp\Unit;

class UnitTransformer
{
    /**
     * @param array $units
     * @return UnitSearchView
     */
    public function transformUnitToSearchView(array $units)
    {
        $views = [];
        foreach ($units as $unit) {
            $views[] = $this->transformUnitToView($unit);
        }

        return new UnitSearchView(
            count($units),
            $views
        );
    }

    /**
     * @param Unit $unit
     * @return UnitView
     */
    public function transformUnitToView(Unit $unit)
    {
        return new UnitView(
            $unit->getId(),
            $unit->getTemperatureUnit(),
            $unit->getSpeedUnit(),
            $unit->getRainUnit(),
            $unit->getSolarRadiationUnit(),
            $unit->getPmUnit(),
            $unit->getHumidityUnit(),
            $unit->getType(),
            $unit->getCreatedAt(),
            $unit->getUpdatedAt()
        );
    }
}
