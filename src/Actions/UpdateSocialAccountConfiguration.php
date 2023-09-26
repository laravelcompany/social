<?php

namespace Cornatul\Social\Actions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

final class UpdateSocialAccountConfiguration extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|int',
            'clientId' => 'required|string',
            'clientSecret' => 'required|string',
            'redirectUri' => 'required|string',
        ];
    }
    public function authorize(): bool
    {
        return true;
    }

}
