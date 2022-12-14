<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Exports\PracticeProviderExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Practice;

class ExportController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        
    }
    public function practice_provider_export(Request $request) 
    {
        $practice = Practice::where('id', $request->id)->pluck('practice_name');
        return Excel::download(new PracticeProviderExport($request->id), $practice[0].'.xlsx');
    }

}
