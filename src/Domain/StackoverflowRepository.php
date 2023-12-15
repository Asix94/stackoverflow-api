<?php

namespace App\Domain;

interface StackoverflowRepository
{
    public function findPopularTags(string $year): PopularTags;
}
