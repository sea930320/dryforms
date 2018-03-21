<?php
namespace App\Services\Dew;

class CalculationService
{
    /**
     * @param double $temperature
     * @param double $rh
     *
     * @return int
     */
    public function calculate($temperature, $rh)
    {
        $temperatureInCelsius = ($temperature - 32) * (5/9);
        $dewPoint = pow(($rh / 100), 1 / 8) * (112 + 0.9 * $temperatureInCelsius) + (0.1 * $temperatureInCelsius) - 112;

        return $dewPoint;
    }
}