<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'body'
    ];

    public function sentBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'sent_by');
    }
}
