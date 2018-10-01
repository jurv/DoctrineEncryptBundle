<?php

namespace Jurv\DoctrineEncryptBundle\Encryptors;

/**
 * AEADxChaCha20Poly1305Encryptor
 *
 * @author Julien Rouvier <julien@integral-service.fr>
 */
class AEADxChaCha20Poly1305Encryptor implements EncryptorInterface
{
    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @param string $secretKey
     */
    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @param string $data
     * @return string
     */
    public function encrypt($data): string
    {
        $nonce = random_bytes(24);
        $encrypted = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt(
            $data,
            $nonce,
            $nonce,
            $this->secretKey
        );

        return $nonce.$encrypted;
    }

    /**
     * @param string $data
     * @return string
     */
    public function decrypt($data): string
    {
        $nonce = mb_substr($data, 0, 24, '8bit');
        $ciphertext = mb_substr($data, 24, null, '8bit');

        $plaintext = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt(
            $ciphertext,
            $nonce,
            $nonce,
            $this->secretKey
        );

        if (!is_string($plaintext)) {
            throw new \UnexpectedValueException();
        }

        return $plaintext;
    }
}
