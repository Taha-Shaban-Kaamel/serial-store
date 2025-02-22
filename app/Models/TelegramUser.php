<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $fillable = [
        'user_name',
        'telegram_name',
        'telegram_id',
        'is_employee',
    ];
}
