<?php

namespace Cornatul\Social\DTO;


use Spatie\LaravelData\Data;

/**
 * @method static self fromRequest(Request $request)
 */
class SocialAccountInformationDTO extends Data
{
    public ?string $access_token;
}
