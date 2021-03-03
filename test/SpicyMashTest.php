<?php

namespace Helper;

use Helper\Exception\BadKeySpicyMashException;

/**
 * Class SpicyMashTest
 * @package Helper
 */
class SpicyMashTest extends TestCase
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

    /**
     * test de RandomBytes
     */
    public function testRandomBytes(): void
    {
        $mash = new SpicyMash();
        $rndByt = $mash->randomBytes(10);
        self::assertEquals(20, strlen($rndByt));
        self::assertMatchesRegularExpression("/^[A-F0-9]+$/i", $rndByt);

        $rndByt = $mash->randomBytes(10, true);
        self::assertEquals(10, strlen($rndByt));
    }

    /**
     * test de Construct
     */
    public function testConstruct(): void
    {
        $mash = new SpicyMash();
        self::assertInstanceOf(SpicyMash::class, $mash);
        self::assertInstanceOf(MashInterface::class, $mash);
        $mash2 = new SpicyMash('AZERTY');
        self::assertInstanceOf(SpicyMash::class, $mash2);
        self::assertInstanceOf(MashInterface::class, $mash2);
    }
}
