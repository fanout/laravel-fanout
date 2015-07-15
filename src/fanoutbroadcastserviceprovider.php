<?php

/*  fanoutbroadcastserviceprovider.php
    This module implements the Fanout broadcast service provider.
    :authors: Konstantin Bokarius.
    :copyright: (c) 2015 by Fanout, Inc.
    :license: MIT, see LICENSE for more details. */

namespace LaravelFanout;

use \Illuminate\Support\ServiceProvider;
use \Fanout\Fanout;

class FanoutBroadcastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->make(
                'Illuminate\Broadcasting\BroadcastManager')->extend(
                'fanout', function ($app, $config) {
            $ssl = true;
            if (array_key_exists('ssl', $config))
                $ssl = $config['ssl'];
            $async = false;
            if (array_key_exists('publish_async', $config))
                $async = $config['publish_async'];
            return new FanoutBroadcaster(new Fanout(
                    $config['realm_id'], $config['realm_key'], $ssl), $async);
        });
    }

    public function register()
    {
    }
}

?>
