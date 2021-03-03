<?php

namespace Helper;

use Helper\Exception\BadKeySpicyMashException;
use Helper\Exception\ErrorSpicyMashException;

/**
 * Class SpicyMash
 * @package Helper
 */
class SpicyMash implements MashInterface
{

    /** @var string|null Clé secrete principale */
    private ?string $key;
    /** @var string méthode de cryptage */
    protected string $cipher;

    /**
     * SpicyMash constructor.
     * @param string|null $masterKey
     */
    public function __construct(?string $masterKey = null)
    {
        $this->cipher = "aes-256-cbc";
        $this->key = $masterKey;
    }

    /**
     * transforme la clé principale et une cle additionnele en une
     * @param string|null $additionnal
     * @return string
     */
    private function getCryptKey(?string $additionnal): string
    {
        return ($additionnal ?? '') . ($this->key ?? '');
    }

    /**
     * @inheritDoc
     * @param string $msg
     * @param string|null $key
     * @return string
     * @throws \Helper\Exception\BadKeySpicyMashException
     */
    public function crypt(string $msg, ?string $key = null): string
    {
        $cryptKey = $this->getCryptKey($key);
        if (empty($cryptKey)) {
            throw new BadKeySpicyMashException("Absence de clé de cryptage");
        }
        $ivLen = (int)openssl_cipher_iv_length($this->cipher);
        $iv = $this->randomBytes($ivLen, true);
        $ciphertext = openssl_encrypt($msg, $this->cipher, $cryptKey, 0, $iv);
        if ($ciphertext === false) {
            throw new ErrorSpicyMashException("Erreur lors du cryptage du message");
        }
        return base64_encode($ciphertext . $iv);
    }

    /**
     * @inheritDoc
     * @param string $raw
     * @param string|null $key
     * @return string
     */
    public function decrypt(string $raw, ?string $key = null): string
    {
        $cryptKey = $this->getCryptKey($key);
        $raw = base64_decode($raw);
        $ivLen = (int)openssl_cipher_iv_length($this->cipher);
        $crypt = substr($raw, 0, -1 * $ivLen);
        $iv = substr($raw, -1 * $ivLen);
        $msg = openssl_decrypt($crypt, $this->cipher, $cryptKey, 0, $iv);
        if ($msg === false) {
            throw new ErrorSpicyMashException("Erreur lors du decryptage du message");
        }
        return $msg;
    }

    /**
     * retourne la méthode de cryptage utilisée
     * @return string
     */
    public function getCipher(): string
    {
        return $this->cipher;
    }

    /**
     * @inheritDoc
     * @param int $length
     * @param bool $raw
     * @return string
     * @noinspection CryptographicallySecureRandomnessInspection
     */
    public function randomBytes(int $length = 8, bool $raw = false): string
    {
        $rndBytes = openssl_random_pseudo_bytes($length, $test);
        if (false === $test || false === $rndBytes) {
            throw new ErrorSpicyMashException('Echec de génération aléatoire');
        }
        if ($raw) {
            return $rndBytes;
        }
        return bin2hex($rndBytes);
    }
}
