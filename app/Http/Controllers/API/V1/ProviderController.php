<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Providers\ProviderRequest;
use App\Models\Provider;
use App\Models\Login;
use Illuminate\Http\Request;

class ProviderController extends BaseController
{
    protected $provider = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Provider $provider)
    {
        $this->middleware('auth:api');
        $this->provider = $provider;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $providers = $this->provider->latest()->paginate(100)->load("practices")->load("payers")->load("documents")->load("logins");
        return $this->sendResponse($providers, 'Provider list');
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
    public function store(ProviderRequest $request)
    {
        $request->validate([

            'individual_npi' => 'required|unique:providers,individual_npi,NULL,id,deleted_at,NULL',
        ]);
//        $validatedData = $request->validated();
        
        $provider = $this->provider->create([
            'individual_npi' => $request->get('individual_npi'),
            'full_name' => $request->get('full_name'),
            'tax_id' => $request->get('tax_id'),
            'ssn' => $request->get('ssn'),
            'speciality' => $request->get('speciality'),
            'provider_signup_date' => $request->get('provider_signup_date'),
            'taxonomy' => $request->get('taxonomy'),
            'taxonomy2' => $request->get('taxonomy2'),
            'home_street' => $request->get('home_street'),
            'home_suite' => $request->get('home_suite'),
            'home_city' => $request->get('home_city'),
            'home_state' => $request->get('home_state'),
            'home_county' => $request->get('home_county'),
            'home_zip' => $request->get('home_zip'),
//            'mailing_street' => $request->get('mailing_street'),
//            'mailing_suite' => $request->get('mailing_suite'),
//            'mailing_city' => $request->get('mailing_city'),
//            'mailing_state' => $request->get('mailing_state'),
//            'mailing_county' => $request->get('mailing_county'),
//            'mailing_zip' => $request->get('mailing_zip'),
            'cell' => $request->get('cell'),
            'gender' => $request->get('gender'),
            'birth_county' => $request->get('birth_county'),
            'birth_state' => $request->get('birth_state'),
            'email' => $request->get('email'),
            'dob' => $request->get('dob'),
            'password' => $request->get('password'),
//            'rail_road_group' => $request->get('rail_road_group'),
            'ptan' => $request->get('ptan'),
            'caqh_user' => $request->get('caqh_user'),
            'caqh_pass' => $request->get('caqh_pass'),
            'caqh_id' => $request->get('caqh_id'),
            'pecos_user' => $request->get('pecos_user'),
            'pecos_pass' => $request->get('pecos_pass'),
            'manager_name' => $request->get('manager_name'),
            'manager_email' => $request->get('manager_email'),
            'manager_contact' => $request->get('manager_contact'),
            'medicaid_id' => $request->get('medicaid_id'),
//            'grp_madicaid_id' => $request->get('grp_madicaid_id'),
//            'grp_mrc_id' => $request->get('grp_mrc_id'),
            'medicaid_user' => $request->get('medicaid_user'),
            'medicare_id' => $request->get('medicare_id'),
            'website' => $request->get('website'),
            'dea' => $request->get('dea'),
            'dea_certification_number' => $request->get('dea_certification_number'),
            'dea_effective_date' => $request->get('dea_effective_date'),
            'dea_expiry_date' => $request->get('dea_expiry_date'),
            'state_license' => $request->get('state_license'),
            'cds_license_option' => $request->get('cds_license_option'),
            'cds_license_number' => $request->get('cds_license_number'),
            'cds_effective_date' => $request->get('cds_effective_date'),
            'cds_expiry_date' => $request->get('cds_expiry_date'),
            'hospital_affiliation' => $request->get('hospital_affiliation'),
            'hospital_name' => $request->get('hospital_name'),
            'hospital_effective_date' => $request->get('hospital_effective_date'),
            'hospital_expiry_date' => $request->get('hospital_expiry_date'),
            'state_license_option' => $request->get('state_license_option'),
            'state_license_number' => $request->get('state_license_number'),
            'state_license_date' => $request->get('state_license_date'),
            'state_license_expiry' => $request->get('state_license_expiry'),
        ]);

        $practices = $request->get('selected_practices');
        $provider->practices()->attach($practices);

        if (($request->get('web_portals'))) {
            foreach ($request->get('web_portals') as $key => $portal) {
                if($portal["loginweb"]=="" && $portal["loginuser"]==""){
                    continue;
                }
                
                $login = new Login;
                $login->provider_id = $provider->id;
                $login->loginweb = $portal["loginweb"];
                $login->loginuser = $portal["loginuser"];
                $login->loginpass = $portal["loginpass"];
                $login->additional_information = $portal["additional_information"];
                $login->save();
            }
        }


        return $this->sendResponse($provider, 'Provider Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $applications = array();
        $provider = $this->provider->findOrFail($id);
//        dd($provider);
        $selected_payers = $provider->payers()->get();
        foreach($selected_payers as $app){
//            dd($app->pivot->provider_identifier);
            $applications[] = ['app_name'=>$app->pivot->payer_id, 'appstatus' => $app->pivot->status, 'appeffective_date' => $app->pivot->effective_date, 'provider_identifier' => $app->pivot->provider_identifier];
        }
//        dd($selected_payers);
        return $this->sendResponse($applications, 'Selected payer list');
    }
    public function payers($id)
    {
        $provider = $this->provider->findOrFail($id);
        $selected_payers = $provider->payers()->get();
        
//        dd($selected_payers);
        return $this->sendResponse($selected_payers, 'Selected payer list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $provider)
    {
        //
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(ProviderRequest $request, $id)
    {
        $request->validate([
            'individual_npi' => 'required|unique:providers,individual_npi,'. $id.',id,deleted_at,NULL',
        ]);

        $practices = $request->get('selected_practices');

        $provider = $this->provider->findOrFail($id);
        
        $provider->update($request->except('selected_practices','id','web_portals'));
        
        $provider->practices()->sync($practices, TRUE);

        $provider->logins()->delete();
        if (($request->get('web_portals'))) {
            foreach ($request->get('web_portals') as $key => $portal) {
                if($portal["loginweb"]=="" && $portal["loginuser"]==""){
                    continue;
                }
                
                $login = new Login;
                $login->provider_id = $provider->id;
                $login->loginweb = $portal["loginweb"];
                $login->loginuser = $portal["loginuser"];
                $login->loginpass = $portal["loginpass"];
                $login->additional_information = $portal["additional_information"];
                $login->save();
            }
        }


        return $this->sendResponse($provider, 'Provider Information has been updated');
    }
    public function allProvidersStatus(Request $request){
        
        $providers = $this->provider->get();
        foreach ($providers as $pro){
            $status_detail = array(
                    'participating' => 0,
                    'non-participating' => 0,
                    'in-process' => 0,
                    'pending-prg' => 0,
                    'pending-provider' => 0,
                    'rejected' => 0,
                    'not-eligible' => 0,
                    'panel-closed' => 0,
                    'approved' => 0,
                    'new' => 0,
                );
            $apps = $pro->payers()->get();
            foreach ($apps as $payer) {
                    $status_detail[$payer->pivot->status] = $status_detail[$payer->pivot->status] + 1;
                }
                
//            dd($pro->full_name);
            $pro->name=$pro->full_name;
            $pro->appstotal=$apps->count();
            $pro->participating=$status_detail['participating'];
            $pro->non_participating=$status_detail['non-participating'];
            $pro->in_process=$status_detail['in-process'];
            $pro->pending_prg=$status_detail['pending-prg'];
            $pro->pending_provider=$status_detail['pending-provider'];
            $pro->rejected=$status_detail['rejected'];
            $pro->not_eligible=$status_detail['not-eligible'];
            $pro->panel_closed=$status_detail['panel-closed'];
            $pro->approved=$status_detail['approved'];
            $pro->new=$status_detail['new'];
            
        }
//        dd($apps->count());
        return $this->sendResponse($providers, 'Provider list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $provider = $this->provider->findOrFail($id);
        $provider->delete();
        return $this->sendResponse($provider, 'Provider has been Deleted');
    }
    public function getProviderPayer($id) {
        $payers=array();
        $provider = Provider::with(['payers.remarks' => function($q) use ($id) {
                        $q->where('provider_id', '=', $id)->orderBy('created_at', 'desc');
                    }])
                ->findOrFail($id);
        
        if($provider){
            $payers = $provider->payers()->get(['payers.id','payers.name']);
        }
        $provider->dob = $provider->dob ? date('m/d/Y', strtotime($provider->dob)):'';
        
        return compact('payers','provider');
    }
}
