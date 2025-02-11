<?php

namespace App\Models;

class Discussion extends Base
{
    protected $fillable = [
        'on',
        'on_id',
        'type',
        'status',
        'title',
        'description'
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }
}
