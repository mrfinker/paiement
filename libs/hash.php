<?php
/**
 *
 */
class Hash
{

    /**
     *
     * @param string $algo The algorithm (md5, sha1, whiripool, etc)
     * @param string $data The data to encode
     * @param string $salt The salt (This should be the same throughout the system probably)
     * @param string The hashed/salted data
     */

    public static function create($algo, $data, $salt)
    {
        $context = hash_init($algo, HASH_HMAC, $salt);
        hash_update($context, $data);

        return hash_final($context);
    }

}
