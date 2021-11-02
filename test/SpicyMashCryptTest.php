<?php

namespace Helper;

use Helper\Exception\BadKeySpicyMashException;

/**
 * Class SpicyMashTest
 * @package Helper
 */
class SpicyMashCryptTest extends TestCase
{

    /**
     * test de Crypt
     */
    public function testCryptAndDecrypt(): void
    {
        $mash = new SpicyMash('Spicy');
        $origin = 'message';
        $crypt = $mash->crypt($origin);
        self::assertNotEquals($origin, $crypt);
        $decrypt = $mash->decrypt($crypt);
        self::assertEquals($origin, $decrypt);
    }


    /**
     * test de Crypt
     */
    public function testCryptWithoutKey(): void
    {
        $this->expectException(BadKeySpicyMashException::class);
        $mash = new SpicyMash();
        $origin = 'message';
        $crypt = $mash->crypt($origin);
    }

    /**
     * test de GetCipher
     */
    public function testGetCipher(): void
    {
        $mash = new SpicyMash();
        self::assertEquals('aes-256-cbc', $mash->getCipher());
    }
}
