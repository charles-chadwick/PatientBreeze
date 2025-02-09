<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Base
{
    use HasFactory;

    protected $fillable = [
        'dob',
        'gender'
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
