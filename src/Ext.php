<?php

namespace Bermuda\Detector;

final class Ext implements \Stringable
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

    public function equals(array|string|self $extensions): bool
    {
        is_array($extensions) ?: $extensions = [$extensions];
        foreach ($extensions as $ext) {
            if (strtolower((string) $ext) === $this->value) return true;
        }

        return false;
    }
}