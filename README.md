# Stable Diffusion integration with Replicate and Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rulilg/laravel-stable-diffusion.svg?style=flat-square)](https://packagist.org/packages/rulilg/laravel-stable-diffusion)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/rulilg/laravel-stable-diffusion/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/rulilg/laravel-stable-diffusion/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/rulilg/laravel-stable-diffusion.svg?style=flat-square)](https://packagist.org/packages/rulilg/laravel-stable-diffusion)

Laravel wrapper around the Replicate API to use Stable Diffusion to generate text2img.

- 🎨 Built-in prompt helper to create better images
- 🚀 Store the results in your database
- 🎇 Generate multiple images in the same API call

## Installation

You can install the package via composer:

```bash
composer require rulilg/laravel-stable-diffusion
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="stable-diffusion-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="stable-diffusion-config"
```

This is the contents of the published config file:

```php
return [
    'url' => env('REPLICATE_URL', 'https://api.replicate.com/v1/predictions'),
    'token' => env('REPLICATE_TOKEN'),
    'version' => env('REPLICATE_STABLEDIFFUSION_VERSION', 'a9758cbfbd5f3c2094457d996681af52552901775aa2d6dd0b17fd15df959bef'),
];

```

Register in [Replicate](https://replicate.com/) and store your token in the `REPLICATE_TOKEN` .env variable.

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-stable-diffusion-views"
```

## Usage

It's important to understand that the image generation process is **async**. We need first to send a request to Replicate and, after a few seconds, we can fetch the results back.

This is the code we need to generate an image. This will return a `StableDiffusionResult` model.

```php
use RuliLG\StableDiffusion\StableDiffusion;
use RuliLG\StableDiffusion\Prompt;

StableDiffusion::make()
    ->withPrompt(
        Prompt::make()
            ->with('a panda sitting on the streets of New York after a long day of walking')
            ->photograph()
            ->resolution8k()
            ->trendingOnArtStation()
            ->highlyDetailed()
            ->dramaticLighting()
            ->octaneRender()
    )
    ->generate(4);
```

After the `generate()` method is called, an API request to Replicate is sent so they can start processing the prompt. This will generate a record in our database with a `status="starting"` value, and the ID returned by Replicate.

To retrieve the results back from Replicate, we need to run the following code:

```php
use RuliLG\StableDiffusion\StableDiffusion;

// we get the Replicate ID and fetch the results back.
// This method will automatically update the record with the new information
$freshResults = StableDiffusion::get($result->replicate_id);
if ($freshResults->is_successful) {
    dd($freshResults->output); // List of URLs with the images
}
```

If the results were already fetched, then no API request will be made, so we can safely call this method every time.

### The StableDiffusionResult model

After a request to Replicate is made, a new record is inserted in your database with the following information:

Column | Description
----- | -----
replicate_id | ID from Replicate, which we can use to retrieve the results back
user_prompt | Prompt passed to the `Prompt::make()->with()` method
full_prompt | Prompt generated with all the modifiers
url | Internal URL to fetch the results back from Replicate
status | Status. Can be one of: `starting`, `processing`, `succeeded`, `failed` or `cancelled`. This library doesn't support cancelling requests.
output | Array of URLs containing the images
error | Error description if needed (i.e. no NSFW content is allowed)
predict_time | Time spent by Replicate processing your image, which you will be charged for

Additionally, the model has the following attributes to know the status of the prediction:

- `$result->is_successful`
- `$result->is_failed`
- `$result->is_starting`
- `$result->is_processing`

Also, as results have to be manually updated through the `StableDiffusion::get($id)` method, we can also fetch the results that are not in a finished status:

```php
use RuliLG\StableDiffusion\Models\StableDiffusionResult;
use RuliLG\StableDiffusion\StableDiffusion;

$results = StableDiffusionResult::unfinished()->get();
foreach ($results as $result) {
    StableDiffusion::get($result->replicate_id);
}
```

## Generating prompts

There are several styles already built-in:

Method | Prompt modification
---- | ----
`realistic()` | {prompt}, realistic
`hyperrealistic()` | {prompt}, hyperrealistic
`conceptArt()` | {prompt}, concept art
`abstractArt()` | {prompt}, abstract art
`oilPainting()` | {prompt}, oil painting
`watercolor()` | {prompt}, watercolor
`acrylic()` | {prompt}, acrylic
`pencilDrawing()` | {prompt}, pencil drawing
`digitalPainting()` | {prompt}, digital painting
`penDrawing()` | {prompt}, pen drawing
`charcoalDrawing()` | {prompt}, charcoal drawing
`byPicasso()` | {prompt}, by Pablo Picasso
`byVanGogh()` | {prompt}, by Vincent Van Gogh
`byRembrandt()` | {prompt}, by Rembrandt
`byMunch()` | {prompt}, by Edvard Munch
`byKlimt()` | {prompt}, by Paul Klimt
`byKandinsky()` | {prompt}, by Jackson Pollock
`byMonet()` | {prompt}, by Claude Monet
`byDali()` | {prompt}, by Salvador Dali
`byDegas()` | {prompt}, by Edgar Degas
`byKahlo()` | {prompt}, by Frida Kahlo
`byCezanne()` | {prompt}, by Pablo Cezanne
`photograph()` | a photo of {prompt}
`highlyDetailed()` | {prompt}, highly detailed
`surrealism()` | {prompt}, surrealism
`trendingOnArtStation()` | {prompt}, trending on art station
`triadicColorScheme()` | {prompt}, triadic color scheme
`smooth()` | {prompt}, smooth
`sharpFocus()` | {prompt}, sharp focus
`matte()` | {prompt}, matte
`elegant()` | {prompt}, elegant
`theMostBeautifulImageEverSeen()` | {prompt}, the most beautiful image ever seen
`illustration()` | {prompt}, illustration
`digitalPaint()` | {prompt}, digital paint
`dark()` | {prompt}, dark
`gloomy()` | {prompt}, gloomy
`octaneRender()` | {prompt}, octane render
`resolution8k()` | {prompt}, 8k
`resolution4k()` | {prompt}, 4k
`washedColors()` | {prompt}, washed colors
`sharp()` | {prompt}, sharp
`dramaticLighting()` | {prompt}, dramatic lighting
`beautiful()` | {prompt}, beautiful
`postProcessing()` | {prompt}, post processing
`pictureOfTheDay()` | {prompt}, picture of the day
`ambientLighting()` | {prompt}, ambient lighting
`epicComposition()` | {prompt}, epic composition

Additionally, you can add custom styles with the following methods:

- `as(string $canvas)`: to add a string at the beginning (i.e. "a photograph of")
- `paintingStyle(string $style)`: to add a painting style (i.e. realistic, hiperrealistic, etc.)
- `by(string $author)`: to instruct the system to paint it with the style of a certain author
- `effect(string $effect)`: to add a finishing touch to the prompt. You can add as many as you want.

To learn more on how to build prompts for Stable Diffusion, please [enter this link](https://beta.dreamstudio.ai/prompt-guide).

## Credits

- [Raúl López](https://github.com/RuliLG)
- [Calima Solutions](https://github.com/calima-solutions)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
