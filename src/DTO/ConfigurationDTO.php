<?php

namespace Cornatul\Social\DTO;


use Spatie\LaravelData\Data;

/**
 * @method static self fromRequest(Request $request)
 */
class ConfigurationDTO extends Data
{
    public ?string $clientId;
    public ?string $clientSecret;
    public ?string $redirectUri;
}
