<?php

/*  fanoutbroadcaster.php
    ~~~~~~~~~
    This module implements the Fanout broadcaster.
    :authors: Konstantin Bokarius.
    :copyright: (c) 2015 by Fanout, Inc.
    :license: MIT, see LICENSE for more details. */

namespace LaravelFanout;

use \Fanout\Fanout;
use \Illuminate\Contracts\Broadcasting\Broadcaster;

class FanoutBroadcaster implements Broadcaster
{
    protected $fanout;
    protected $async;

    public function __construct(Fanout $fanout, $async = false)
    {
        $this->fanout = $fanout;
        $this->async = $async;
    }

    public function broadcast(array $channels, $event, array $payload = array())
    {
        $payload = ['event' => $event, 'data' => $payload];
        foreach ($channels as $channel) {
            if ($this->async)
                $this->fanout->publish_async($channel, $payload);
            else
                $this->fanout->publish($channel, $payload);
        }
    }
}

?>
