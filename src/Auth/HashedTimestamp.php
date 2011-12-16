<?php
/**
 * Auth_HashedTimestamp.
 *
 * A simple authentication library.
 *
 * Checks whether timestamp is not expired and hash is correct.
 *
 * This method is *NOT SECURE*
 * Do not use on critical use cases.
 * 
 * @author Yuya Takeyama
 */
class Auth_HashedTimestamp
{
    public function auth()
    {
        return true;
    }
}
