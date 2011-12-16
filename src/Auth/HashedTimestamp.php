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
     * Current timestamp provider.
     *
     * @var callable
     */
    protected $_currentTimestampProvider;

    /**
     * Constructor.
     *
     * @param callable $hashGenerator            Function to generate hash from timestmap.
     * @param int      $expiration               Expiration seconds.
     * @param int      $currentTimestampProvider Current timestamp provider. (Optional)
     *                                           Default provider returns time().
     */
    public function __construct($hashGenerator, $expiration, $currentTimestampProvider = NULL)
    {
        $this->_hashGenerator = $hashGenerator;
        $this->_expiration    = $expiration;
        $this->_currentTimestampProvider = isset($currentTimestampProvider) ?
            $currentTimestampProvider :
            function () {
                return time();
            };
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
        return ($this->_getCurrentTimestamp() - $timestamp) <= $this->_expiration &&
            $hash === $this->generateHash($timestamp);
    }

    /**
     * Generates hash from timestamp.
     *
     * @param  int $timestamp
     * @return string Hash string as signature.
     */
    public function generateHash($timestamp)
    {
        return call_user_func($this->_hashGenerator, $timestamp);
    }

    /**
     * Gets current timestamp.
     *
     * Just calls current timestamp provider.
     *
     * @return int
     */
    protected function _getCurrentTimestamp()
    {
        return call_user_func($this->_currentTimestampProvider);
    }
}
