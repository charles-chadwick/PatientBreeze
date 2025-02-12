<?php

namespace App\Http\Controllers;

use App\Enums\DiscussionType;
use App\Http\Requests\StoreDiscussionRequest;
use App\Http\Requests\UpdateDiscussionRequest;
use App\Models\Discussion;
use Illuminate\Support\Facades\Request;

class DiscussionController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index($type = DiscussionType::PrivateMessage) {
        return Discussion::with('users', 'posts')
            ->withType($type)
            ->get();
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Discussion $discussion) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discussion $discussion) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscussionRequest $request, Discussion $discussion) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discussion $discussion) {
        //
    }
}
