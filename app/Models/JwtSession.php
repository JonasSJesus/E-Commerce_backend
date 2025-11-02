<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $token_id
 * @property int $user_id
 * @property string $ip_address
 * @property string $user_agent
 * @property string $last_activity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JwtSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JwtSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JwtSession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JwtSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JwtSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JwtSession whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JwtSession whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JwtSession whereTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JwtSession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JwtSession whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JwtSession whereUserId($value)
 * @mixin \Eloquent
 */
class JwtSession extends Model
{
    protected $fillable = [
        'token_id',
        'user_id',
        'ip_address',
        'user_agent',
        'last_activity',
        'expires_at'
    ];

    protected function casts(): array
    {
        return [
            'lat_activity'      => 'datetime',
            'created_at'        => 'datetime',
            'updated_at'        => 'datetime',
        ];
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('d-m-Y H:i:s');
    }
}
