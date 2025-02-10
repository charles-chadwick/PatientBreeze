<?php


namespace App\Observers;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;

/**
 */
class DocumentObserver {

    public function creating(Document $document): Model {

    }

    public function created(Document $document): void {}

    public function updating(Document $document): Model {}

    public function updated(Document $document): void {}

    public function deleting(Document $document): Model {}

    public function deleted(Document $document): void {}
}
