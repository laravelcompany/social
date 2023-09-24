<?php

namespace Cornatul\Social\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class SocialAccount
 * @package Cornatul\Social\Models
 * @property int $id
 * @property int $user_id
 * @property string $account
 * @property SocialAccountConfiguration $configuration
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static create(array $data)
 */
class SocialAccount extends Model
{

    protected $table = 'social_accounts';

    public $fillable = [
        'user_id',
        'account',
    ];

    public final function configuration(): HasMany
    {
        return $this->hasMany(SocialAccountConfiguration::class);
    }
}
