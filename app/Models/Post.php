<?php

namespace App\Models;

use App\Models\User;
use App\Models\Report;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title' , 'thumbnail' , 'user_id' , 'slug' , 'tags' , 'content'] ;

    protected $casts = [
        'tags' => 'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function reports(){
        return $this->hasMany(Report::class);
    }

    public function getRouteKeyName(){
        return 'slug';
    }
}
