<?php

namespace Cornatul\Social\DTO;


use Spatie\LaravelData\Data;

class ConfigurationDTO extends Data
{
    public string $clientId;
    public string $clientSecret;
    public string $redirectUri;
}
