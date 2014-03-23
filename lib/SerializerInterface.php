<?php
/**
 * This file is part of the WebScale Serializer library. It is licenced under
 * MIT licence. For more information, see LICENSE file that
 * was distributed with this library.
 */
namespace WebScale\Serializer;

interface SerializerInterface
{
    public function serialize($data);

    public function unserialize($data);
}
