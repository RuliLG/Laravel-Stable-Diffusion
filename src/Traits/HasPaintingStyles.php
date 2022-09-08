<?php

namespace RuliLG\StableDiffusion\Traits;

trait HasPaintingStyles
{
    public function paintingStyle(string $style): static
    {
        $this->paintingStyle = $style;

        return $this;
    }

    public function realistic(): static
    {
        return $this->paintingStyle('realistic');
    }

    public function hyperrealistic(): static
    {
        return $this->paintingStyle('hyperrealistic');
    }

    public function conceptArt(): static
    {
        return $this->paintingStyle('concept art');
    }

    public function abstractArt(): static
    {
        return $this->paintingStyle('abstract art');
    }

    public function oilPainting(): static
    {
        return $this->paintingStyle('oil painting');
    }

    public function watercolor(): static
    {
        return $this->paintingStyle('watercolor');
    }

    public function acrylic(): static
    {
        return $this->paintingStyle('acrylic');
    }

    public function pencilDrawing(): static
    {
        return $this->paintingStyle('pencil drawing');
    }

    public function digitalPainting(): static
    {
        return $this->paintingStyle('digital painting');
    }

    public function penDrawing(): static
    {
        return $this->paintingStyle('pen drawing');
    }

    public function charcoalDrawing(): static
    {
        return $this->paintingStyle('charcoal drawing');
    }
}
