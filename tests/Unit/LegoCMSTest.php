<?php

namespace LegoCMS\Tests\Unit;

use Mockery;

class LegoCMSTest extends TestCase
{
    /**
     * @test
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function testNotSoBasicTest()
    {
        $this->assertFalse(false);
    }
}
