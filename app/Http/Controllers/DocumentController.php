<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class DocumentController extends Controller {

    protected $document = '';

    public function __construct(Document $document)
    {
        
        $this->document = $document;
    }

    public function show($id) {
        $document = $this->document->findOrFail($id);
        $file = storage_path() . "/documents/provider/" . $document->name;
            return Response::file($file);
        // if (auth()->user()->cant('view', $document)) {
        //     return abort(403);
        // } else {
        //     $file = storage_path() . "/documents/provider/" . $document->name;
        //     return Response::file($file);
        // }
    }

    public function download(Document $document) {
        dd($document->name);
        return Storage::download(public_path() . 'img/documents' . $document->name);
    }

    public function getDownload(Document $document) {
        $file = storage_path() . "/documents/provider/" . $document->document_type()->type;
        return Response::download($file, 'test');
    }
   

}
