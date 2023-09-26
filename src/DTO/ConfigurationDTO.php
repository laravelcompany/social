<?php

namespace Cornatul\Social\DTO;


use Spatie\LaravelData\Data;

/**
 * @method static self fromRequest(Request $request)
 * @method static self fromArray(array $data)
 * @method static self fromJson(string $json)
 * @method static self fromString(string $string)
 * @method static self fromObject(object $object)
 */
class ConfigurationDTO extends Data
{
    public ?string $clientId;
    public ?string $clientSecret;
    public ?string $redirectUri;
    public ?array $scope = [];
}
