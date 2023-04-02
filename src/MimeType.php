<?php

namespace Bermuda\Detector;

final class MimeType implements \Stringable
{
    public readonly string $value;
    public function __construct(string $value)
    {
        $this->value = strtolower($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(array|string|self $types): bool
    {
        is_array($types) ?: $types = [$types];
        foreach ($types as $type) {
            if (strtolower((string) $type) === $this->value) return true;
        }

        return false;
    }
    
    /**
     * @param string $type
     * @return bool
     */
    public function contains(string $type): bool
    {
        return str_contains($this->value, strtolower($type));
    }
}
