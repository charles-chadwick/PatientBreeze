<?php

namespace App\Models;

class DiscussionPost extends Base
{
    protected $table = 'discussion_posts';

    protected $fillable = [
        'discussion_id',
        'order',
        'status',
        'content'
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }
}
