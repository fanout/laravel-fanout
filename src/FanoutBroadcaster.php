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
use \Illuminate\Http\Request;

class FanoutBroadcaster implements Broadcaster
{
    protected $fanout;
    protected $async;

    public function __construct(Fanout $fanout, $async = false)
    {
        $this->fanout = $fanout;
        $this->async = $async;
    }

    /**
     * Authenticate the incoming request for a given channel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function auth($request)
    {

    }

    /**
     * Return the valid authentication response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $result
     * @return mixed
     */
    public function validAuthenticationResponse($request, $result)
    {

    }

    /**
     * Broadcast the given event.
     *
     * @param  array  $channels
     * @param  string  $event
     * @param  array  $payload
     * @return void
     */
    public function broadcast(array $channels, $event, array $payload = [])
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
