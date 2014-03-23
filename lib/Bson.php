<?php
/**
 * This file is part of the WebScale Serializer library. It is licenced under
 * MIT licence. For more information, see LICENSE file that
 * was distributed with this library.
 */
namespace WebScale\Serializer;

use RuntimeException;

/**
 * Might cause problems with some objects.
 * Test carefully!
 */
class Bson implements SerializerInterface
{
    public function __construct()
    {
        if (!extension_loaded('mongo')) {
            throw new RuntimeException('mongo extension required');
        }
    }

    public function serialize($data)
    {
        return bson_encode($data);
    }

    public function unserialize($data)
    {
        return bson_decode($data);
    }
}
