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

}
