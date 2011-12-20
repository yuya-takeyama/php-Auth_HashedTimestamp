Auth\_HashedTimestamp
=====================

master: [![Build Status](https://secure.travis-ci.org/yuya-takeyama/php-Auth_HashedTimestamp.png?branch=master)](http://travis-ci.org/yuya-takeyama/php-Auth\_HashedTimestamp)
develop: [![Build Status](https://secure.travis-ci.org/yuya-takeyama/php-Auth_HashedTimestamp.png?branch=develop)](http://travis-ci.org/yuya-takeyama/php-Auth\_HashedTimestamp)

A simple authentication library.

Checks whether timestamp is not expired and hash is correct.

This method is *NOT SECURE*  
Do not use on critical use cases.

This library is compatible to PHP 5.2.

Synopis
-------

Hash generator.

```php
<?php
require_once 'Auth/HashedTimestamp.php';

$authenticator = new Auth_HashedTimestamp(7, function ($timestamp) {
    return md5($timestamp);
});
$timestamp = time();
$hash      = $authenticator->generateHash($timestamp);
$url       = "auth.php?timestamp={$timestamp}&hash={$hash}";

echo '<a href="' . htmlspecialchars($url) . '">This URL expires in 7 seconds</a>';
```

Authenticator.

```php
<?php
require_once 'Auth/HashedTimestamp.php';

$authenticator = new Auth_HashedTimestamp(7, function ($timestamp) {
    return md5($timestamp);
});
if ($authenticator->auth((int)$_GET['timestamp'], $_GET['hash'])) {
    echo "Welcome!";
} else {
    echo "Forbidden.";
}
```

Author
------

Yuya Takeyama
