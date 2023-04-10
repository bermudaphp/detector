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
            $type = strtolower((string) $type);
            if ($type === $this->value) return true;
            if ((str_ends_with($type, '*'))) {
                $needle = explode('/', $type, 2)[0];
                if ($this->contains($needle)) return true;
            }
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
