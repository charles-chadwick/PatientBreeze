<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\MorphTo;

class Discussion extends Base
{
    protected $table = 'discussions_posts';
    protected $fillable = [
        'on',
        'on_id',
        'type',
        'status',
        'title'
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }

    public function discussable(): MorphTo {
        return $this->morphTo('discussion', 'on', 'on_id');
    }

}
