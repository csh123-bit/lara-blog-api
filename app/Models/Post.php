<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Post extends Model
{
    use HasFactory;

    protected $fillable=[
        'subject',
        'content',
    ];

    public function comments(){
        return $this->hasMany(\App\Models\Comment::class);
    }

    public function categories(){
        return $this->belongsToMany(\App\Models\Category::class );
    }
}
