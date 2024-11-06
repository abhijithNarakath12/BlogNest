<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected function title() : Attribute {
        return Attribute::make(
            set: fn (string $value) => ucwords(strtolower($value)),
        );
    }
    
    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
