<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;
    protected $fillable =[
        'title',
        'content',
        'published'
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected function setTitleAttribute($value) {
        $this->attributes['title'] = ucwords(strtolower($value));        
    }
    
    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }
}