<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommentLikeUser extends Model
{
    use HasFactory;

    /**
     * Database table.
     *
     * @var string
     */
    protected $table = 'comment_like_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'comment_id',
        'user_id',
        'is_like'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'comment_id' => 'int',
        'user_id' => 'int',
        'is_like' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'id');
    }
}
