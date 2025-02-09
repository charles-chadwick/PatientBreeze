<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Base
{
    protected $fillable = [
        'on',
        'on_id',
        'status',
        'type',
        'title',
        'description',
        'file_name',
        'original_file_name'
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }
}
