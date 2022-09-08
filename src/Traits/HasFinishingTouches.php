<?php

namespace RuliLG\StableDiffusion\Traits;

trait HasFinishingTouches
{
    public function effect(string $effect): static
    {
        $this->finishingTouches[] = $effect;

        return $this;
    }

    public function highlyDetailed(): static
    {
        return $this->effect('highly detailed');
    }

    public function surrealism(): static
    {
        return $this->effect('surrealism');
    }

    public function trendingOnArtStation(): static
    {
        return $this->effect('trending on art station');
    }

    public function triadicColorScheme(): static
    {
        return $this->effect('triadic color scheme');
    }

    public function smooth(): static
    {
        return $this->effect('smooth');
    }

    public function sharpFocus(): static
    {
        return $this->effect('sharp focus');
    }

    public function matte(): static
    {
        return $this->effect('matte');
    }

    public function elegant(): static
    {
        return $this->effect('elegant');
    }

    public function theMostBeautifulImageEverSeen(): static
    {
        return $this->effect('the most beautiful image ever seen');
    }

    public function illustration(): static
    {
        return $this->effect('illustration');
    }

    public function digitalPaint(): static
    {
        return $this->effect('digital paint');
    }

    public function dark(): static
    {
        return $this->effect('dark');
    }

    public function gloomy(): static
    {
        return $this->effect('gloomy');
    }

    public function octaneRender(): static
    {
        return $this->effect('octane render');
    }

    public function resolution8k(): static
    {
        return $this->effect('8k');
    }

    public function resolution4k(): static
    {
        return $this->effect('4k');
    }

    public function washedColors(): static
    {
        return $this->effect('washed colors');
    }

    public function sharp(): static
    {
        return $this->effect('sharp');
    }

    public function dramaticLighting(): static
    {
        return $this->effect('dramatic lighting');
    }

    public function beautiful(): static
    {
        return $this->effect('beautiful');
    }

    public function postProcessing(): static
    {
        return $this->effect('post processing');
    }

    public function pictureOfTheDay(): static
    {
        return $this->effect('picture of the day');
    }

    public function ambientLighting(): static
    {
        return $this->effect('ambient lighting');
    }

    public function epicComposition(): static
    {
        return $this->effect('epic composition');
    }
}
