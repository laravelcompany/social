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
class UserInformationDTO extends Data
{
    /**
     * // OAuth 2.0 providers
     * 'token' => $user->token,
     * 'refreshToken' => $user->refreshToken,
     * 'expiresIn' => $user->expiresIn,
     *
     * // All providers
     * 'id' => $user->getId(),
     * 'nickname' => $user->getNickname(),
     * 'name' => $user->getName(),
     * 'email' => $user->getEmail(),
     * 'avatar' => $user->getAvatar(),
     */

    public ?string $token;
    public ?string $refreshToken;
    public ?string $expiresIn;
    public ?string $id;
    public ?string $nickname;
    public ?string $name;
    public ?string $email;
    public ?string $avatar;
}
