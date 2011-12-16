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
    /**
     * Function to generate hash from timestamp.
     *
     * @var callable
     */
    private $_hashGenerator;

    /**
     * Expiration seconds.
     *
     * @var int
     */
    private $_expiration;

    /**
     * Criteria timestamp.
     *
     * @var int
     */
    private $_criteriaTimestamp;

    /**
     * Constructor.
     *
     * @param callable $hashGenerator     Function to generate hash from timestmap.
     * @param int      $expiration        Expiration seconds.
     * @param int      $criteriaTimestamp Criteria timestamp. (Optional)
     *                                    Default is result of time().
     */
    public function __construct($hashGenerator, $expiration, $criteriaTimestamp = NULL)
    {
        $this->_hashGenerator     = $hashGenerator;
        $this->_expiration        = $expiration;
        $this->_criteriaTimestamp = isset($criteriaTimestamp) ? $criteriaTimestamp : time();
    }

    /**
     * Authentication.
     *
     * @param  string $hash Hash string as signature.
     * @param  int    $now  Current timestamp.
     * @return bool
     */
    public function auth($hash, $timestamp)
    {
        return ($timestamp - $this->_criteriaTimestamp) <= $this->_expiration;
    }
}
