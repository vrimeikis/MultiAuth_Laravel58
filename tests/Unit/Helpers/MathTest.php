<?php

declare(strict_types = 1);

namespace Tests\Unit\Helpers;

use App\Helpers\Math;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MathTest extends TestCase
{
    /**
     * @group math-helper
     * @dataProvider percentCalculateData
     *
     * @param $firstData
     * @param $secondData
     * @param $expectedData
     */
    public function testCalculatePercent($firstData, $secondData, $expectedData): void {
        $result = Math::calculatePercent($firstData, $secondData);

        $this->assertSame($expectedData, $result);
    }

    /**
     * @return array
     */
    public function percentCalculateData(): array {
        return [
            [
                'firstData' => 100,
                'secondData' => 40,
                'expectedData' => 40.0,
            ],
            [
                'firstData' => 100,
                'secondData' => 50,
                'expectedData' => 50.0,
            ],
            [
                'firstData' => 40,
                'secondData' => 100,
                'expectedData' => 250.0,
            ],
            'div by zero' => [
                'firstData' => 0,
                'secondData' => 100,
                'expectedData' => 0.0,
            ],
            'second zero' => [
                'firstData' => 100,
                'secondData' => 0,
                'expectedData' => 0.0,
            ],
        ];
    }
}
