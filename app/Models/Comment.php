<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function post(){
        return $this->belongsTo(\App\Models\Post::class);
    }

    public function user(){
        return $this->belongsTo(\app\Models\User::class);
    }
}
