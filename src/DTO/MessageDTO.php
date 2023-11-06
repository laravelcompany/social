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
class MessageDTO extends Data
{
    public function __construct(
        public string $message,
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
