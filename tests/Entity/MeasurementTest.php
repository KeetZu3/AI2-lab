<?php

namespace App\Tests\Entity;

use App\Entity\DaneMeteorologiczne;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{

    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new DaneMeteorologiczne();
        $measurement->setTemperaturaWCelsjuszach($celsius);

        $this->assertEquals($expectedFahrenheit, $measurement->getFahrenheit());
    }


    public function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['0.5', 32.9],
            ['-273.5', -460.30],
            ['-50 ', -58.0],
            ['1000', 1832.0],
            ['600', 1112.],
            ['13.5', 56.3],
            ['1', 33.80],
            ['28.5', 83.30],
            ['-11.5', 11.30],
            ['-0.5', 31.1],
        ];
    }

}
