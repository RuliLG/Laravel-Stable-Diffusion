<?php

return [
    'url' => env('REPLICATE_URL', 'https://api.replicate.com/v1/predictions'),
    'token' => env('REPLICATE_TOKEN'),
    'version' => env('REPLICATE_STABLEDIFFUSION_VERSION', 'a9758cbfbd5f3c2094457d996681af52552901775aa2d6dd0b17fd15df959bef'),
];
