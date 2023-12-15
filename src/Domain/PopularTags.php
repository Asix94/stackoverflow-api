<?php

namespace App\Domain;

use App\Shared\Collection;

final class PopularTags extends Collection
{
    public static function create(string $year, array $popularTags): PopularTags
    {
        return new self($popularTags);
    }
    protected function type(): string
    {
        return PopularTag::class;
    }
}
