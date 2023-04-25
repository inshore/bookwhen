<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Contracts;

use ArrayAccess;

/**
 * @template TArray of array
 *
 * @extends ArrayAccess<key-of<TArray>, value-of<TArray>>
 *
 * @internal
 */
interface ResponseContract extends ArrayAccess
{
    /**
     * @param  key-of<TArray>  $offset
     */
    public function offsetExists(mixed $offset): bool;

    /**
     * @template TOffsetKey of key-of<TArray>
     *
     * @param  TOffsetKey  $offset
     * @return TArray[TOffsetKey]
     */
    public function offsetGet(mixed $offset): mixed;

    /**
     * @template TOffsetKey of key-of<TArray>
     *
     * @param  TOffsetKey  $offset
     * @param  TArray[TOffsetKey] $value
     */
    public function offsetSet(mixed $offset, mixed $value): never;

    /**
     * @template TOffsetKey of key-of<TArray>
     *
     * @param  TOffsetKey  $offset
     */
    public function offsetUnset(mixed $offset): never;
}
