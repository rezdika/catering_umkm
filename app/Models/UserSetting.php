<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'email_notifications',
        'sms_notifications', 
        'promo_notifications',
        'two_factor_enabled',
        'language',
        'timezone',
        'dark_mode'
    ];

    protected $casts = [
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'promo_notifications' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'dark_mode' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
