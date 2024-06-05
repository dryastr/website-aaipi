<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Hashing\AbstractHasher;
use RuntimeException;

class AaipiHasher extends AbstractHasher implements HasherContract
{
    private const SALT = '9263a915e8bf1fc5bb219302708dfdfea3669fe3b80665e791550a66878a8720';

    private const COST = 8;

    public function make($value, array $options = [])
    {
        $salt = $this->salt($options);
        $cost = $this->cost($options);

        $hash = password_hash($value.$salt, PASSWORD_DEFAULT, [
            'cost' => $cost,
        ]);

        if ($hash === false) {
            throw new RuntimeException('Aaipi hashing not supported.');
        }

        return $hash;
    }

    /**
     * Verifies that the configuration is less than or equal to what is configured.
     *
     * @internal
     */
    public function verifyConfiguration($value)
    {
        return $this->isUsingCorrectAlgorithm($value);
    }

    /**
     * Verify the hashed value's algorithm.
     *
     * @param  string  $hashedValue
     * @return bool
     */
    protected function isUsingCorrectAlgorithm($hashedValue)
    {
        return $this->info($hashedValue);
    }

    /**
     * Get information about the given hashed value.
     *
     * @param  string  $hashedValue
     * @return array
     */
    public function info($hashedValue)
    {
        return password_get_info($hashedValue);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }

        $salt = $this->salt($options);

        return password_verify($value.$salt, $hashedValue);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string  $hashedValue
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        $cost = $this->cost($options);

        return password_needs_rehash($hashedValue, PASSWORD_DEFAULT, [
            'cost' => $cost,
        ]);
    }

    /**
     * Extract the cost value from the options array.
     *
     *
     * @return int
     */
    protected function cost(array $options = [])
    {
        return $options['cost'] ?? self::COST;
    }

    /**
     * Extract the salt value from the options array.
     *
     *
     * @return int
     */
    protected function salt(array $options = [])
    {
        return $options['salt'] ?? self::SALT;
    }
}
