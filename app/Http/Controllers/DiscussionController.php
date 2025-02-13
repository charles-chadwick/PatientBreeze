<?php

namespace App\Http\Controllers;

use App\Enums\DiscussionPostStatus;
use App\Enums\DiscussionType;
use App\Http\Requests\Discussions\StoreDiscussionRequest;
use App\Http\Requests\Discussions\UpdateDiscussionRequest;
use App\Models\Discussion;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Inertia\Inertia;

class DiscussionController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index($type = DiscussionType::PrivateMessage) {
        return Inertia::render('Discussions/Index', [
            'discussions' => Discussion::with('users', 'posts', 'created_by')
                ->withType($type)
                ->get()
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscussionRequest $request) {

        $discussion = Discussion::create($request->only('type', 'status', 'title'));
        $discussion->addUsers(request()->get('users'));
        $discussion->posts()->create([
            'status' => DiscussionPostStatus::Unread,
            'content' => $request->get('content')
        ]);

        return $discussion;
    }

    /**
     * Display the specified resource.
     */
    public function show(Discussion $discussion): Discussion {
        return Discussion::with('users', 'posts')->find($discussion->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discussion $discussion) {
        $discussion->removeUsers();
        return $discussion->delete();
    }
}
