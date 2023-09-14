<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;
    protected $table="admin_notification";
    protected $primaryKey="id";
    protected $fillable = ['user_id','title','click_url','is_read'];
}
