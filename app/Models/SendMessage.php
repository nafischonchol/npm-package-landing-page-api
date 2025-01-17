<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendMessage extends Model
{
    protected $fillable = [
        'email',
        'phone',
        'name',
        'subject',
        'text',
    ];
}
