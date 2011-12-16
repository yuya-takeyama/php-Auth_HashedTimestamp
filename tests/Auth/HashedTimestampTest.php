<?php
require_once dirname(__FILE__) . '/../../src/Auth/HashedTimestamp.php';

class Auth_HashedTimestampTest extends PHPUnit_Framework_TestCase
{
    const TIMESTAMP          = 1324034000;
    const CORRECT_HASH       = '1324034000';
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
        $authenticator = $this->createAuthenticatorFromCurrentTimestamp(self::TIMESTAMP);
        $this->assertTrue($authenticator->auth(self::TIMESTAMP, self::CORRECT_HASH));
    }

    /**
     * @test
     */
    public function auth_should_be_true_if_timestamp_is_just_expiration_time()
    {
        $authenticator = $this->createAuthenticatorFromCurrentTimestamp(
            self::TIMESTAMP + self::EXPIRATION_SECONDS
        );
        $this->assertTrue($authenticator->auth(self::TIMESTAMP, self::CORRECT_HASH));
    }

    /**
     * @test
     */
    public function auth_should_be_false_if_timestamp_is_expired()
    {
        $authenticator = $this->createAuthenticatorFromCurrentTimestamp(
            self::TIMESTAMP + self::EXPIRATION_SECONDS + 1 // expired!
        );
        $this->assertFalse($authenticator->auth(self::TIMESTAMP, self::CORRECT_HASH));
    }

    /**
     * @test
     */
    public function auth_should_be_false_if_hash_is_incorrect()
    {
        $authenticator = $this->createAuthenticatorFromCurrentTimestamp(self::TIMESTAMP);
        $this->assertFalse($authenticator->auth(self::TIMESTAMP, 'Incorrect Hash'));
    }

    /**
     * @test
     */
    public function generateHash_should_be_hash_generated_by_hash_generator()
    {
        $authenticator = $this->createAuthenticatorFromCurrentTimestamp(self::TIMESTAMP);
        $timestamp     = time();
        $this->assertEquals(
            call_user_func($this->_hashGenerator, $timestamp),
            $authenticator->generateHash($timestamp)
        );
    }

    /**
     * Creates Auth_HashedTimestamp object with specified current timestamp.
     *
     * @param  int $currentTimestamp
     * @return Auth_HashedTimestamp
     */
    protected function createAuthenticatorFromCurrentTimestamp($currentTimestamp)
    {
        return new Auth_HashedTimestamp(
            $this->_hashGenerator,
            self::EXPIRATION_SECONDS,
            function () use ($currentTimestamp) {
                return $currentTimestamp;
            }
        );
    }
}
