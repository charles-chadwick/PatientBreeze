<?php

namespace App\Models;


use App\Enums\DiscussionType;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Discussion extends Base
{
    protected $table = 'discussions';
    protected $fillable = [
        'type',
        'status',
        'title'
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }

    /**
     * Posts relationship
     * @return HasMany
     */
    public function posts() : HasMany {
        return $this->hasMany(DiscussionPost::class, 'discussion_id');
    }

    /**
     * Users relationship
     * @return BelongsToMany
     */
    public function users() : BelongsToMany {
        return $this->belongsToMany(User::class, 'discussions_users', 'discussion_id', 'user_id');
    }

    /**
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeWithType($query, $type): mixed {
        return $query->where('type', $type);
    }
}
