<?php

namespace RuliLG\StableDiffusion\Traits;

trait HasCanvases
{
    public function as(string $canvas): self
    {
        $this->canvas = $canvas;

        return $this;
    }

    public function photograph(): self
    {
        return $this->as('a photo');
    }

    public function paperSheet(): self
    {
        return $this->as('a paper sheet');
    }
}
