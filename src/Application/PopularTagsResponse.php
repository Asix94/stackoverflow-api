<?php

namespace App\Application;

use App\Domain\PopularTag;
use App\Domain\PopularTags;

use function Lambdish\Phunctional\map;

final class PopularTagsResponse
{
    public function popularTags(PopularTags $popularTags): array
    {
        return map(function (PopularTag $popularTag) {
            return ["tag" => $popularTag->tag(), "questions" => $popularTag->questions()];
        }, $popularTags->items());
    }
}
