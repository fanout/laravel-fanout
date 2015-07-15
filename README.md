laravel-fanout
-------------
Author: Konstantin Bokarius <kon@fanout.io>

Fanout.io library for Laravel.

Requirements
------------

* openssl
* curl
* pthreads (required for asynchronous publishing)
* laravel >= 5.1
* fanout/pubcontrol >=2.0.0 (retrieved automatically via Composer)

Installation
------------

Using Composer:

```sh
composer require fanout/laravel-fanout
```

Manual: ensure that php-pubcontrol has been included and require the following files in laravel-fanout:

```PHP
require 'laravel-fanout/src/laravelfanout.php';
```

Asynchronous Publishing
-----------------------

In order to make asynchronous publish calls pthreads must be installed. If pthreads is not installed then only synchronous publish calls can be made. To install pthreads recompile PHP with the following flag: '--enable-maintainer-zts'

Also note that since a callback passed to the publish_async methods is going to be executed in a separate thread, that callback and the class it belongs to are subject to the rules and limitations imposed by the pthreads extension.

See more information about pthreads here: http://php.net/manual/en/book.pthreads.php

Sample usage
------------

Put your Fanout.io credentials in settings.py:

```python
FANOUT_REALM = 'my-realm-id'
FANOUT_KEY = 'my-realm-key'
```

Then you can publish JSON objects from anywhere in your project:

```python
import django_fanout as fanout

fanout.publish('some-channel', 'hello')
```
