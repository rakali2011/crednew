<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Exports\PracticeProviderExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        
    }
    public function practice_provider_export(Request $request) 
    {
        return Excel::download(new PracticeProviderExport($request->id), 'practice.xlsx');
    }

}
