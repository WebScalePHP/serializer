<?php
/**
 * This file is part of the WebScale Serializer library. It is licenced under
 * MIT licence. For more information, see LICENSE file that
 * was distributed with this library.
 */
namespace WebScale\Serializer;

use RuntimeException;
use InvalidArgumentException;

class Compressor implements SerializerInterface
{
    protected $wrapped;

    protected $threshold;

    protected $factor;

    /**
     * Construnctor
     *
     * @param \WebScale\Serializer\SerializerInterface $wrapped
     * @param int $threshold
     *     Do not compress serialized values below this limit.
     * @param float $factor
     *     Compress serialized values only if the compression factor (saving) exceeds
     *     this. Default value 1.3 translates to 23% space saving.
     */
    public function __construct(SerializerInterface $wrapped, $threshold = 1000, $factor = 1.3)
    {
        if (!extension_loaded('zlib')) {
            throw new RuntimeException('zlib extension required');
        }
        $this->wrapped = $wrapped;
        $this->threshold = $threshold;
        $this->factor = $factor;
    }

    public function serialize($data)
    {
        $data = $this->wrapped->serialize($data);
        $len = strlen($data);
        if ($len >= $this->threshold) {
            if ($len > (strlen($compressed = gzcompress($data)) * $this->factor)) {
                return "1|$compressed";
            }
        }
        return "0|$data";
    }

    public function unserialize($data)
    {
        $data = explode('|', $data, 2);
        if ($data[0] == '1') {
            $data[1] = gzuncompress($data[1]);
        } elseif ($data[0] == '0') {
            // ok
        } else {
            throw new InvalidArgumentException('Cannot parse given data');
        }
        return $this->wrapped->unserialize($data[1]);
    }
}
