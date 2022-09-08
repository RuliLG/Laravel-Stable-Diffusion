<?php

namespace RuliLG\StableDiffusion\Commands;

use Illuminate\Console\Command;

class StableDiffusionCommand extends Command
{
    public $signature = 'laravel-stablediffusion';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
