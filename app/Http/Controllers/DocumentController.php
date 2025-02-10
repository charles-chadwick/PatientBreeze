<?php

namespace App\Http\Controllers;

use App\Enums\DocumentStatus;
use App\Enums\DocumentType;
use App\Http\Requests\Documents\StoreDocumentRequest;
use App\Http\Requests\Documents\UpdateDocumentRequest;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Document::with('documentable')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {
        $file = $request->file('upload');

        $tmp_file_name = uniqid('a_') . '.' . $file->getClientOriginalExtension();
        Storage::putFile(public_path("storage/avatars/$tmp_file_name"), $file);
        $user = User::find($request->get('user_id'));
        $document = Document::create([
                'on'                => auth()->id(),
                'status'             => DocumentStatus::Accepted,
                'file_name'          => $tmp_file_name,
                'original_file_name' => $file->getClientOriginalName(),
                'title'              => "$user->first_name's Avatar",
                'type'               => DocumentType::Avatar,
            ]);

        $user->avatar()->attach($document->id);

        return $user;

    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
