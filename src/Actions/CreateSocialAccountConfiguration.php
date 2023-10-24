<?php

namespace Cornatul\Social\Actions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

final class CreateSocialAccountConfiguration extends FormRequest
{
    public function rules(): array
    {
        return [
            'account' => 'required|int',
            'type' => 'required|string',
            'clientId' => 'required|string',
            'clientSecret' => 'required|string',
            'redirectUri' => 'required|string',
            'scopes' => 'nullable|string',
        ];
    }
    public function authorize(): bool
    {
        return true;
    }

}
