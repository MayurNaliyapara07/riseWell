<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    use HasFactory;
    protected $table="notification_template";
    protected $primaryKey="notification_template_id";
    protected $fillable = ['act', 'name', 'subj', 'email_body', 'sms_body', 'shortcodes', 'email_status', 'sms_status'];
}
