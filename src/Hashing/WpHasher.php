<?php

namespace Cosname\Hashing;

use Hautelook\Phpass\PasswordHash;
use Illuminate\Hashing\AbstractHasher;
use Illuminate\Hashing\HashManager;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class WpHasher extends AbstractHasher implements HasherContract
{
    /**
     * @var \Hautelook\Phpass\PasswordHash
     */
    protected static $wp_hasher;

    /**
     * @var \Illuminate\Hashing\HashManager
     */
    protected static $flarum_hasher;

    /**
     * Set the hashers with which to hash passwords.
     *
     * @param PasswordHash $wp_hasher
     * @param HashManager $flarum_hasher
     */
    public static function setHashers(PasswordHash $wp_hasher, HashManager $flarum_hasher)
    {
        static::$wp_hasher = $wp_hasher;
        static::$flarum_hasher = $flarum_hasher;
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
        return WpHasher::$flarum_hasher->make($value);
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
               WpHasher::$flarum_hasher->check($value, $hashedValue, $options);
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
         return WpHasher::$flarum_hasher->needsRehash($hashedValue, $options);
     }
}
