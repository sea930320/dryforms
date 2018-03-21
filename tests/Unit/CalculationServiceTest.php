<?php
namespace Tests\Unit;

use App\Services\Dew\CalculationService;
use Tests\TestCase;

class CalculationServiceTest extends TestCase
{
    /**
     * @test
     */
    public function testCalculation()
    {
        $service = new CalculationService();

        $this->assertEquals(-59.45628434135354, $service->calculate(1, 1));
    }

    /**
     * @test
     */
    public function testCalculationTwo()
    {
        $service = new CalculationService();

        $this->assertEquals(-6.070814072734265, $service->calculate(25, 85));
    }
}