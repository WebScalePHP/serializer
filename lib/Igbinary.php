<?php
/**
 * This file is part of the WebScale Serializer library. It is licenced under
 * MIT licence. For more information, see LICENSE file that
 * was distributed with this library.
 */
namespace WebScale\Serializer;

use RuntimeException;

class Igbinary implements SerializerInterface
{
    public function __construct()
    {
        if (!extension_loaded('igbinary')) {
            throw new RuntimeException('igbinary extension required');
        }
    }

    public function serialize($data)
    {
        return igbinary_serialize($data);
    }

    public function unserialize($data)
    {
        return igbinary_unserialize($data);
    }
}
