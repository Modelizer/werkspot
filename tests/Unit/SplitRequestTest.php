<?php

namespace Tests\Unit;

use App\Http\Middleware\SplitTesting;
use PHPUnit\Framework\TestCase;

class SplitRequestTest extends TestCase
{
    /** @test */
    public function it_should_check_request()
    {
        // This is a sample test to know if we use mt_rand to generate a random number between 1 to 100. Then the
        // probability of sending ~30% requests is much closer in sending 1000 or more requests.
        // The more requests more data will be accurate.
        $werkspotUrlCompressRequests = 0;

        // 10000 is the total request we sent
        for ($i = 1; $i <= 10000; $i++) {
            SplitTesting::isGreatorThan30Percent() ? $werkspotUrlCompressRequests++ : null;
        }

        $roundingPercentage = ceil($werkspotUrlCompressRequests / 100);

        // This shows the percentage is between 70, 71, 72
        $this->assertTrue(in_array($roundingPercentage, [70, 71, 72]));
    }
}
