<?php

namespace Helper;

use Helper\Exception\BadKeySpicyMashException;

/**
 * Class SpicyMashTest
 * @package Helper
 */
class SpicyMashHashTest extends TestCase
{
    /**
     * test du Hash
     */
    public function testHash(): void
    {
        $mash = new SpicyMash();
        $origin = 'message';
        $crypt = $mash->hash($origin);
        self::assertIsString($origin, $crypt);
        self::assertEquals(hash('sha512', $origin), $crypt);
    }
}
