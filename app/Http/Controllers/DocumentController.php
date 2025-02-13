<?php /** @noinspection ALL */

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
        $user = User::find($request->get('user_id'));

        return $user->avatar()
            ->create([
                'size'               => $file->getSize(),
                'mime_type'          => $file->getMimeType(),
                'status'             => $request->get('status'),
                'file_name'          => Document::uploadDocument($file),
                'original_file_name' => $file->getClientOriginalName(),
                'title'              => $request->get('title', "Document"),
                'type'               => $request->get('type'),
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        return $document->delete();
    }
}
