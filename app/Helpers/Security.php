<?php

declare(strict_types=1);

namespace App\Helpers;

class Security
{
    /**
     *Constructor
     */
    public function __construct()
    {
    }

    /**
     * Custom sha256
     */
    public static function sha256(string $hashedValue): string
    {
        return hash('sha256', md5($hashedValue));
    }

    /**
     * Custom sha256 original
     */
    public static function sha256Original(string $hashedValue): string
    {
        return hash('sha256', $hashedValue);
    }

    /**
     * Encrypt for SPIP Service
     */
    public static function encrypt($string): string
    {
        $encryptMethod = config('aaipi.security.encrypt_method');
        $secretKey = config('aaipi.security.secret_key');
        $secretIv = config('aaipi.security.secret_iv');

        // hash
        $key = hash('sha256', $secretKey);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secretIv), 0, 16);
        $string = serialize($string);
        $output = openssl_encrypt($string, $encryptMethod, $key, 0, $iv);

        return base64_encode($output);
    }

    /**
     * Decrypt for SPIP Service
     *
     *
     * @return string
     */
    public static function decrypt($string): mixed
    {
        try {
            $output = false;
            $encryptMethod = config('aaipi.security.encrypt_method');
            $secretKey = config('aaipi.security.secret_key');
            $secretIv = config('aaipi.security.secret_iv');

            // hash
            $key = hash('sha256', $secretKey);

            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hash('sha256', $secretIv), 0, 16);
            $output = openssl_decrypt(base64_decode($string), $encryptMethod, $key, 0, $iv);

            return unserialize($output);
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Generate Key
     */
    public static function generateKey(int $length = 12, int $level = 2): string
    {
        [$usec, $sec] = explode(' ', microtime());
        srand((int) $sec + ((int) $usec * 100000));

        $validchars[1] = '0123456789abcdfghjkmnpqrstvwxyz';
        $validchars[2] = '0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $validchars[3] = '0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/';

        $generateKey = '';
        $counter = 0;

        while ($counter < $length) {
            $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level]) - 1), 1);
            // All character must be different
            if (! strstr($generateKey, $actChar)) {
                $generateKey .= $actChar;
                $counter++;
            }
        }

        return $generateKey;
    }

    /**
     * Bypass Token Body
     */
    public static function checkTokenBody(string $token, string $combineToken): bool
    {
        if (config('aaipi.security.token_bypass')) {
            return true;
        }

        return $token === self::sha256($combineToken);
    }
}
