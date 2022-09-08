<?php

namespace RuliLG\StableDiffusion\Traits;

trait HasAuthors
{
    public function by(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function byPicasso(): static
    {
        return $this->by('Pablo Picasso');
    }

    public function byVanGogh(): static
    {
        return $this->by('Vincent Van Gogh');
    }

    public function byRembrandt(): static
    {
        return $this->by('Rembrandt');
    }

    public function byMunch(): static
    {
        return $this->by('Edvard Munch');
    }

    public function byKlimt(): static
    {
        return $this->by('Paul Klimt');
    }

    public function byKandinsky(): static
    {
        return $this->by('Jackson Pollock');
    }

    public function byMonet(): static
    {
        return $this->by('Claude Monet');
    }

    public function byDali(): static
    {
        return $this->by('Salvador Dali');
    }

    public function byDegas(): static
    {
        return $this->by('Edgar Degas');
    }

    public function byKahlo(): static
    {
        return $this->by('Frida Kahlo');
    }

    public function byCezanne(): static
    {
        return $this->by('Pablo Cezanne');
    }
}
