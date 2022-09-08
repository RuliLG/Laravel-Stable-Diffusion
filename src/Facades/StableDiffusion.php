<?php

namespace RuliLG\StableDiffusion\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RuliLG\StableDiffusion\StableDiffusion
 */
class StableDiffusion extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \RuliLG\StableDiffusion\StableDiffusion::class;
    }
}
