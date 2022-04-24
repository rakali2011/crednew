<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Practices\PracticeRequest;
use App\Models\Practice;
use App\Models\Tag;
use Illuminate\Http\Request;

class PracticeController extends BaseController
{
    protected $practice = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Practice $practice)
    {
        $this->middleware('auth:api');
        $this->practice = $practice;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $practices = $this->practice->latest()->get()->load("documents");
        return $this->sendResponse($practices, 'Practice list');
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing()
    {
        $practices = $this->practice->select("practice_name","id")->get();
//        $practices = $this->practice->pluck('practice_name', 'id');

        return $this->sendResponse($practices, 'Practice list');
    }
    public function getProviders($id)
    {
        $practice = $this->practice->findOrFail($id);
        
        $providers = $practice->providers()->get();
//        $practices = $this->practice->pluck('practice_name', 'id');

        return $this->sendResponse($providers, 'Providers list');
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
     * @param  App\Http\Requests\Practices\PracticeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PracticeRequest $request)
    {
        $practice = $this->practice->create([
            'practice_name' => $request->get('practice_name'),
            'practice_code' => $request->get('practice_code'),
            'client_name' => $request->get('client_name'),
            'group_npi' => $request->get('group_npi'),
            'practice_tax_id' => $request->get('practice_tax_id'),
            'speciality' => $request->get('speciality'),
            'taxnomy' => $request->get('taxnomy'),
            'clia' => $request->get('clia'),
            'clia_expiry' => $request->get('clia_expiry'),
            'dba_name' => $request->get('dba_name'),
            'prac_classification' => $request->get('prac_classification'),
            'grp_madicaid_id' => $request->get('grp_madicaid_id'),
            'grp_mrc_id' => $request->get('grp_mrc_id'),
            'rail_road_group' => $request->get('rail_road_group'),
            'service_address' => $request->get('service_address'),
            'service_city' => $request->get('service_city'),
            'service_state' => $request->get('service_state'),
            'service_zip' => $request->get('service_zip'),
            'service_fax' => $request->get('service_fax'),
            'service_phone' => $request->get('service_phone'),
            'service_county' => $request->get('service_county'),
            'pay_address' => $request->get('pay_address'),
            'pay_city' => $request->get('pay_city'),
            'pay_state' => $request->get('pay_state'),
            'pay_zip' => $request->get('pay_zip'),
            'pay_fax' => $request->get('pay_fax'),
            'pay_phone' => $request->get('pay_phone'),
            'pay_county' => $request->get('pay_county'),
            'contact1_name' => $request->get('contact1_name'),
            'contact1_email' => $request->get('contact1_email'),
            'contact1_phone' => $request->get('contact1_phone'),
            'contact1_mobile' => $request->get('contact1_mobile'),
            'owner_name' => $request->get('owner_name'),
            'onwer_email' => $request->get('onwer_email'),
            'owner_phone' => $request->get('owner_phone'),
            'owner_mobile' => $request->get('owner_mobile'),
        ]);

        return $this->sendResponse($practice, 'Practice Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Practice  $practice
     * @return \Illuminate\Http\Response
     */
    public function show(Practice $practice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Practice  $practice
     * @return \Illuminate\Http\Response
     */
    public function edit(Practice $practice)
    {
        //
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Practice  $practice
     * @return \Illuminate\Http\Response
     */
    public function update(PracticeRequest $request, $id)
    {
        $practice = $this->practice->findOrFail($id);

        $practice->update($request->all());

        return $this->sendResponse($practice, 'Practice Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Practice  $practice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $practice = $this->practice->findOrFail($id);
        $practice->delete();
        return $this->sendResponse($practice, 'Practice has been Deleted');
    }
}
