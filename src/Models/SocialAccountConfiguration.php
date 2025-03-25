<?php

namespace Cornatul\Social\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * * @param string $token
 * * @param string $secret
 * * @param int $social_account_id
 * * @method static create(array $data)
 * * @method static find (int $id)
 * * @method static where (string $column, string $value)
 * * @method static inRandomOrder()
 */
class SocialAccountConfiguration extends Model
{
    protected $table = "social_accounts_configuration";

    protected $fillable= [
        'social_account_id',
        'type',
        'configuration',
        'information'
    ];


    public final function account():BelongsTo
    {
        return $this->belongsTo(SocialAccount::class);
    }

    public final function getConfigurationAttribute(string | null $value):object|null
    {
        return json_decode($value);
    }

    public final function getInformationAttribute(string | null $value):object|null
    {
        return json_decode($value);
    }
}
