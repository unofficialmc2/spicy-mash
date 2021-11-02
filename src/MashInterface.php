<?php
namespace Helper;

/**
 * Interface MashInterface
 * @package Helper
 */
interface MashInterface
{
    /**
     * génère des bytes aléatoires
     * @param int $length
     * @param bool $raw
     * @return string
     */
    public function randomBytes(int $length = 8, bool $raw = false): string;

    /**
     * encrypte un message
     * @param string $msg
     * @param string|null $key
     * @return string
     */
    public function crypt(string $msg, ?string $key = null): string;

    /**
     * decrypte un message
     * @param string $raw
     * @param string|null $key
     * @return string
     */
    public function decrypt(string $raw, ?string $key = null): string;

    /**
     * hash un message
     * @param string $msg
     * @param bool $raw
     * @return string
     */
    public function hash(string $msg, bool $raw = false): string;
}
