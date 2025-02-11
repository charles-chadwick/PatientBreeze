<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscussionPost extends Base {
	protected $table    = 'discussions_posts';
	protected $fillable = [
		'discussion_id',
		'order',
		'status',
		'content'
	];

	public function __construct(array $attributes = []) {
		parent::__construct($attributes);
	}

	public function discussion(): BelongsTo {
		return $this->belongsTo(Discussion::class);
	}
}
