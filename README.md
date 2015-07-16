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
* fanout/fanout >=2.0.0 (retrieved automatically via Composer)

Installation
------------

Using Composer:

```sh
composer require fanout/laravel-fanout
```

Manual: ensure that php-fanout has been included and require the following files in laravel-fanout:

```PHP
require 'laravel-fanout/src/fanoutbroadcaster.php';
require 'laravel-fanout/src/fanoutbroadcastserviceprovider.php';
```

Asynchronous Publishing
-----------------------

In order to make asynchronous publish calls pthreads must be installed. If pthreads is not installed then only synchronous publish calls can be made. To install pthreads recompile PHP with the following flag: '--enable-maintainer-zts'

Also note that since a callback passed to the publish_async methods is going to be executed in a separate thread, that callback and the class it belongs to are subject to the rules and limitations imposed by the pthreads extension.

See more information about pthreads here: http://php.net/manual/en/book.pthreads.php

Usage
------------

In your config/broadcasting.php file set the default driver to 'fanout' and add the connection configuration like so:

```php
'default' => 'fanout',

'connections' => [
    ...
    'fanout' => [
        'driver' => 'fanout',
        'realm_id' => '<my-realm-id>',
        'realm_key' => '<my-realm-key>',
        'ssl' => true,
        'publish_async' => false
    ],
    ...
]
```

In your config/app.php file add the following to your service providers array:

```php
'providers' => [
    ...
    LaravelFanout\FanoutBroadcastServiceProvider::class,
    ...
]
```

Add a custom broadcast event to your application like so:

```php
namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PublishToFanoutEvent implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return ['<channel>'];
    }
}
```

Now to publish to Fanout.io in your application simply fire the event:

```php
event(new App\Events\PublishToFanoutEvent('Test publish!!'));
```
