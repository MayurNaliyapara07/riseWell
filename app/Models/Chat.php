<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends BaseModel
{
    use HasFactory;
    protected $table="chat";
    protected $primaryKey="chat_id";
    protected $fillable=['patients_id','user_id','content'];
}
