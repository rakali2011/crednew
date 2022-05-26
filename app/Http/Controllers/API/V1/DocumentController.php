<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Documents\DocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use DateTime;

class DocumentController extends BaseController
{
    protected $document = '';
    
    public function __construct(Document $document)
    {
        $this->middleware('auth:api');
        $this->document = $document;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = $this->document->latest()->with('document_type')->get();
        return $this->sendResponse($documents, 'Document list');
    }
    Public function validateDate($date, $format = 'm/d/Y') {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function doctypes()
    {
        $document_types =  \App\Models\Document_type::select("id","type")->get();

        return $this->sendResponse($document_types, 'Document type list');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'provider_id' => 'required|integer',
            'document_type_id' => 'required',
            'issue_date' => 'max:255',
            'expiry_date' => 'max:255',
        ]);
        $request->validate([
            'file_name' => 'required',
        ]);
        $files = $request["file_name"];
        foreach($files as $file){
            $name = time() . $file->getClientOriginalName();
            $file->move(storage_path() . '/documents/provider', $name);
        
        $document = new Document;

        $document->provider_id = request('provider_id');
        $document->document_type_id = request('document_type_id');
        $document->user_id = auth()->user()->id;
//        $document->issue_date = $this->validateDate(request('issue_date')) ? date('Y-m-d', strtotime(request('issue_date'))) : NULL;
//        $document->expiry_date = $this->validateDate(request('expiry_date')) ? date('Y-m-d', strtotime(request('expiry_date'))) : NULL;
        $document->issue_date = request('issue_date');
        $document->expiry_date = request('expiry_date');
        $document->name = $name;
        $document->save();
    }
        return $this->sendResponse("", 'Document Created Successfully');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
            $document = $this->document->findOrFail($id);
            $file = url() . "/documents/provider/" . $document->name;
            dd($file);
//            return Response::file($file);
            return $this->sendResponse($file, 'Document fetched successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}
