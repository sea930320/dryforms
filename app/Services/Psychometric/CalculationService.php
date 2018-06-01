<?php

namespace App\Services\Psychometric;

use Illuminate\Database\Connection;

class CalculationService
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * CalculationService constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param int $temperature
     * @param int $rh
     * @return int
     */
    public function calculate(int $temperature, int $rh): int
    {
        $psychometricData = $this->connection->table('psychometric_calculations')
            ->where([
                'temperature' => $temperature,
                'rh' => $rh
            ])->first();
        if(isset($psychometricData)){
            return $psychometricData->result;
        }
        return 0;
    }
}