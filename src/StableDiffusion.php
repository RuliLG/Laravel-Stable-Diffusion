<?php

namespace RuliLG\StableDiffusion;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use RuliLG\StableDiffusion\Models\StableDiffusionResult;

class StableDiffusion
{
    private function __construct(
        public ?Prompt $prompt = null,
        private int $width = 512,
        private int $height = 512,
    ) {
    }

    public static function make(): self
    {
        return new self();
    }

    public static function get(string $replicateId)
    {
        $result = StableDiffusionResult::where('replicate_id', $replicateId)->first();
        assert($result !== null, 'Unknown id');

        $idleStatuses = ['starting', 'processing'];
        if (! in_array($result->status, $idleStatuses)) {
            return $result;
        }

        $response = self::make()
            ->client()
            ->get($result->url)
            ->json();

        $result->update([
            'status' => Arr::get($response, 'status', $result->status),
            'output' => Arr::get($response, 'output'),
            'error' => Arr::get($response, 'error'),
            'predict_time' => Arr::get($response, 'metrics.predict_time'),
        ]);

        return $result;
    }

    public function withPrompt(Prompt $prompt)
    {
        $this->prompt = $prompt;

        return $this;
    }

    public function width(int $width)
    {
        assert($width > 0, 'Width must be greater than 0');
        assert($width <= 768 && $this->width <= 1024, 'Width must be lower than 768 and height lower than 1024');
        assert($width <= 1024 && $this->width <= 768, 'Width must be lower than 768 and height lower than 1024');
        $this->width = $width;

        return $this;
    }

    public function height(int $height)
    {
        assert($height > 0, 'Height must be greater than 0');
        assert($height <= 768 && $this->width <= 1024, 'Height must be lower than 768 and width lower than 1024');
        assert($height <= 1024 && $this->width <= 768, 'Height must be lower than 768 and width lower than 1024');
        $this->height = $height;

        return $this;
    }

    public function generate(int $numberOfImages): StableDiffusionResult
    {
        assert($this->prompt !== null, 'You must provide a prompt');
        assert($numberOfImages > 0, 'You must provide a number greater than 0');

        $response = $this->client()
            ->post(config('stable-diffusion.url'), [
                'version' => config('stable-diffusion.version'),
                'input' => [
                    'prompt' => $this->prompt->toString(),
                ],
            ])
            ->json();

        $result = StableDiffusionResult::create([
            'replicate_id' => $response['id'],
            'user_prompt' => $this->prompt->userPrompt(),
            'full_prompt' => $this->prompt->toString(),
            'url' => $response['urls']['get'],
            'status' => $response['status'],
            'output' => $response['output'],
            'error' => $response['error'],
            'predict_time' => null,
        ]);

        return $result;
    }

    private function client(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => 'Token '.config('stable-diffusion.token'),
        ])
            ->asJson()
            ->acceptJson();
    }
}
