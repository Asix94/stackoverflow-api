<?php

namespace App\Domain;

final class PopularTag
{
    private string $tag;
    private int $questions;
    public function __construct(string $tag, int $questions )
    {
        $this->tag = $tag;
        $this->questions = $questions;
    }

    public static function create(string $tag, int $questions): PopularTag
    {
        return new self($tag, $questions);
    }

    public function tag(): string
    {
        return $this->tag;
    }

    public function questions(): int
    {
        return $this->questions;
    }
}
