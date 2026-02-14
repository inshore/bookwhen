<?php

declare(strict_types=1);

namespace InShore\Bookwhen;

use InShore\Bookwhen\Contracts\TransporterContract;
use InShore\Bookwhen\Interfaces\ClientInterface;
use InShore\Bookwhen\Resources\Attachments;
use InShore\Bookwhen\Resources\ClassPasses;
use InShore\Bookwhen\Resources\Events;
use InShore\Bookwhen\Resources\Locations;
use InShore\Bookwhen\Resources\Tickets;

/**
 * Low-level API client for Bookwhen resources.
 *
 * Obtain via BookwhenApi::client($apiKey) or BookwhenApi::factory()->...->make().
 */
class Client implements ClientInterface
{
    public function __construct(private readonly TransporterContract $transporter)
    {
    }

    /**
     * Attachments resource (list/retrieve).
     *
     * @return Attachments
     */
    public function attachments(): Attachments
    {
        return new Attachments($this->transporter);
    }

    /**
     * Class passes resource (list/retrieve).
     *
     * @return ClassPasses
     */
    public function classPasses(): ClassPasses
    {
        return new ClassPasses($this->transporter);
    }

    /**
     * Events resource (list/retrieve).
     *
     * @return Events
     */
    public function events(): Events
    {
        return new Events($this->transporter);
    }

    /**
     * Locations resource (list/retrieve).
     *
     * @return Locations
     */
    public function locations(): Locations
    {
        return new Locations($this->transporter);
    }

    /**
     * Tickets resource (list/retrieve).
     *
     * @return Tickets
     */
    public function tickets(): Tickets
    {
        return new Tickets($this->transporter);
    }
}
