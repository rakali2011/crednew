<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Practicedoc;
use Illuminate\Http\Request;

class PracticedocController extends BaseController
{
    protected $practicedoc = '';
    
    public function __construct(Practicedoc $practicedoc)
    {
        $this->middleware('auth:api');
        $this->practicedoc = $practicedoc;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = $this->practicedoc->latest()->paginate(100);
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
            'practice_id' => 'required|integer',
            'document_type_id' => 'required',
            'issue_date' => 'max:255',
            'expiry_date' => 'max:255',
        ]);
        $request->validate([
            'file_name' => 'required|file|max:5120',
        ]);

        if ($request->hasfile('file_name')) {
//            $request->validate([
//                'file_name' => 'mimes:pdf,jpeg,png,bmp,tiff |max:102400',
//            ]);
            $file = $request->file('file_name');
            $name = time() . $file->getClientOriginalName();
            $file->move(storage_path() . '/documents/practice', $name);
        }
        $document = new Practicedoc;

        $document->practice_id = request('practice_id');
        $document->document_type_id = request('document_type_id');
        $document->user_id = auth()->user()->id;
//        $document->issue_date = $this->validateDate(request('issue_date')) ? date('Y-m-d', strtotime(request('issue_date'))) : NULL;
//        $document->expiry_date = $this->validateDate(request('expiry_date')) ? date('Y-m-d', strtotime(request('expiry_date'))) : NULL;
        $document->issue_date = request('issue_date');
        $document->expiry_date = request('expiry_date');

        if ($request->hasfile('file_name')) {
            $document->name = $name;
        }
        $document->save();
        return $this->sendResponse($document, 'Document Created Successfully');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Practicedoc  $practicedoc
     * @return \Illuminate\Http\Response
     */
    public function show(Practicedoc $practicedoc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Practicedoc  $practicedoc
     * @return \Illuminate\Http\Response
     */
    public function edit(Practicedoc $practicedoc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Practicedoc  $practicedoc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Practicedoc $practicedoc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Practicedoc  $practicedoc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Practicedoc $practicedoc)
    {
        //
    }
}
