<?php

namespace App\Models;


use App\Enums\DiscussionType;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;

class Discussion extends Base {
    protected $table    = 'discussions';
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
     *
     * @return HasMany
     */
    public function posts(): HasMany {
        return $this->hasMany(DiscussionPost::class, 'discussion_id');
    }

    /**
     * Users relationship
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany {
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

    /**
     * Add one or more user from the discussion
     *
     * @param array $user_ids
     * @return void
     */
    public function addUsers(array $user_ids): void {

        $this->users()
            ->attach($user_ids,
                [
                    'created_at' => now(), 'created_by' => 1
                ]);

        activity('db-operations')
            ->performedOn($this)
            ->causedBy(User::find(1))
            ->withProperty('user_ids', $user_ids)
            ->log('added users');
    }

    /**
     * Remove one or more users from the discussion
     *
     * @param array|null $user_ids
     * @return void
     */
    public function removeUsers(array $user_ids = null): void {

        if (is_null($user_ids)) {
            $user_ids = $this->users()
                ->pluck('user_id');
        }

        DB::table('discussions_users')
            ->whereIn('user_id', $user_ids)
            ->where('discussion_id', $this->id)
            ->update(['deleted_at' => now(), 'deleted_by' => 1]);

        activity('db-operations')
            ->performedOn($this)
            ->causedBy(User::find(1))
            ->withProperty('user_ids', $user_ids)
            ->log('deleted users');
    }
}
