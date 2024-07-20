<?php

namespace RuliLG\StableDiffusion;

use RuliLG\StableDiffusion\Traits\HasAuthors;
use RuliLG\StableDiffusion\Traits\HasCanvases;
use RuliLG\StableDiffusion\Traits\HasFinishingTouches;
use RuliLG\StableDiffusion\Traits\HasPaintingStyles;

class Prompt
{
    use HasAuthors;
    use HasCanvases;
    use HasFinishingTouches;
    use HasPaintingStyles;

    private function __construct(
        protected string $prompt = '',
        protected ?string $paintingStyle = null,
        protected ?string $author = null,
        protected ?string $canvas = null,
        protected array $finishingTouches = [],
    ) {}

    public static function make(): Prompt
    {
        return new Prompt();
    }

    public function with(string $prompt): static
    {
        $this->prompt = $prompt;

        return $this;
    }

    public function toString(): string
    {
        $prompt = $this->prompt;
        if ($this->author) {
            $prompt .= ', made by '.$this->author;
        }

        if ($this->canvas) {
            $prompt = $this->canvas.' of '.$prompt;
        }

        if ($this->paintingStyle) {
            $prompt .= ', '.$this->paintingStyle;
        }

        if (! empty($this->finishingTouches)) {
            $prompt .= ', '.implode(', ', array_values(array_unique($this->finishingTouches)));
        }

        return $prompt;
    }

    public function userPrompt(): string
    {
        return $this->prompt;
    }
}
