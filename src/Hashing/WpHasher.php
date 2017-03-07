<?php

namespace Cosname\Hashing;

use Hautelook\Phpass\PasswordHash;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class WpHasher implements HasherContract
{
    /**
     * @var \Hautelook\Phpass\PasswordHash
     */
    protected static $wp_hasher;

    /**
     * @var \Illuminate\Hashing\BcryptHasher
     */
    protected static $bcrypt_hasher;

    /**
     * Set the hashers with which to hash passwords.
     *
     * @param PasswordHash $wp_hasher
     * @param BcryptHasher $bcrypt_hasher
     */
    public static function setHashers(PasswordHash $wp_hasher, BcryptHasher $bcrypt_hasher)
    {
        static::$wp_hasher = $wp_hasher;
        static::$bcrypt_hasher = $bcrypt_hasher;
    }

    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @param  array   $options
     * @return string
     */
    public function make($value, array $options = [])
    {
        return WpHasher::$bcrypt_hasher->make($value);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        // If the hash is still md5
        if (strlen($hashedValue) <= 32) {
            return ($hashedValue == md5($value));
        }

        // If the stored hash is longer than an MD5, try both hashers
        return WpHasher::$wp_hasher->CheckPassword($value, $hashedValue) ||
               WpHasher::$bcrypt_hasher->check($value, $hashedValue, $options);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
     public function needsRehash($hashedValue, array $options = [])
     {
         return WpHasher::$bcrypt_hasher->needsRehash($hashedValue, $options);
     }
}
