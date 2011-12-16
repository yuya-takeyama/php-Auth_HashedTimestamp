<?php
require_once dirname(__FILE__) . '/../../src/Auth/HashedTimestamp.php';

class Auth_HashedTimestampTest extends PHPUnit_Framework_TestCase
{
    const CRITERIA_TIMESTAMP = 1324034000;

    public function setUp()
    {
        $this->_hashGenerator = function ($timestamp) {
            return (string)$timestamp; // Only returns timestamp as string!
        };
    }

    /**
     * @test
     */
    public function auth_should_be_true_if_timestamp_is_not_expired_and_hash_is_correct()
    {
        $authenticator = new Auth_HashedTimestamp(
            $this->_hashGenerator,
            60,
            self::CRITERIA_TIMESTAMP
        );
        $now  = self::CRITERIA_TIMESTAMP;
        $hash = call_user_func($this->_hashGenerator, $now);
        $this->assertTrue($authenticator->auth($now, $hash));
    }
}
