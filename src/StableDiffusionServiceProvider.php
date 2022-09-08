<?php

namespace RuliLG\StableDiffusion;

use RuliLG\StableDiffusion\Commands\StableDiffusionCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class StableDiffusionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-stable-diffusion')
            ->hasConfigFile()
            ->hasMigration('create_stable_diffusion_results_table');
    }
}
