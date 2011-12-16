<?php
require_once dirname(__FILE__) . '/../../src/Auth/HashedTimestamp.php';

class Auth_HashedTimestampTest extends PHPUnit_Framework_TestCase
{
    const CRITERIA_TIMESTAMP = 1324034000;
    const EXPIRATION_SECONDS = 60;

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
        $this->assertTrue($authenticator->auth($hash, $now));
    }

    /**
     * @test
     */
    public function auth_should_be_true_if_timestamp_is_just_expiration_time()
    {
        $authenticator = new Auth_HashedTimestamp(
            $this->_hashGenerator,
            60,
            self::CRITERIA_TIMESTAMP
        );
        $now  = self::CRITERIA_TIMESTAMP + self::EXPIRATION_SECONDS;
        $hash = call_user_func($this->_hashGenerator, $now);
        $this->assertTrue($authenticator->auth($hash, $now));
    }

    /**
     * @test
     */
    public function auth_should_be_false_if_timestamp_is_expired()
    {
        $authenticator = new Auth_HashedTimestamp(
            $this->_hashGenerator,
            60,
            self::CRITERIA_TIMESTAMP
        );
        $now  = self::CRITERIA_TIMESTAMP + self::EXPIRATION_SECONDS + 1; // expired!
        $hash = call_user_func($this->_hashGenerator, $now);
        $this->assertFalse($authenticator->auth($hash, $now));
    }

    /**
     * @test
     */
    public function auth_should_be_false_if_hash_is_incorrect()
    {
        $authenticator = new Auth_HashedTimestamp(
            $this->_hashGenerator,
            60,
            self::CRITERIA_TIMESTAMP
        );
        $now  = self::CRITERIA_TIMESTAMP;
        $hash = 'Incorrect Hash';
        $this->assertFalse($authenticator->auth($hash, $now));
    }
}
