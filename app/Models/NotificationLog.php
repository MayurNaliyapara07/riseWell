<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;
    protected $table="notification_logs";
    protected $primaryKey="notification_logs_id";
    protected $fillable = [
        'user_id',
        'sender',
        'sent_from',
        'sent_to',
        'subject',
        'message',
        'notification_type',
    ];
}
