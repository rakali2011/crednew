<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Payers\PayerRequest;
use App\Models\Payer;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class PayerController extends BaseController
{
    protected $payer = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Payer $payer)
    {
        $this->middleware('auth:api');
        $this->payer = $payer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payers = $this->payer->latest()->paginate(100);
        return $this->sendResponse($payers, 'Payer list');
    }
    
    public function listing() {
        $payers = $this->payer->select("name", "id")->get();
//        $practices = $this->practice->pluck('practice_name', 'id');

        return $this->sendResponse($payers, 'Payer list');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PayerRequest $request)
    {
        $payer = $this->payer->create([
            'name' => strtoupper($request->get('name')),
        ]);
        return $this->sendResponse($payer, 'Payer Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payer  $payer
     * @return \Illuminate\Http\Response
     */
    public function show(Payer $payer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payer  $payer
     * @return \Illuminate\Http\Response
     */
    public function edit(Payer $payer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payer  $payer
     * @return \Illuminate\Http\Response
     */
    public function update(PayerRequest $request, Payer $payer)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255', Rule::unique('payers')->ignore($payer->id)],
        ]);
        $validatedData['name'] = strtoupper($validatedData['name']);
        $payer->update(['name' => $validatedData['name']]);
        return $this->sendResponse($payer, 'Payer Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payer  $payer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payer $payer)
    {
        //
    }
}
