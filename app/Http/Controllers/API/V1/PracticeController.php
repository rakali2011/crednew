<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Practices\PracticeRequest;
use App\Models\Practice;
use App\Models\Plocation;
use App\Models\Plogin;
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
        $practices = $this->practice->latest()->get()->load("documents")->load("plocations");
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
            'software_name' => $request->get('software_name'),
            'clear_house_name' => $request->get('clear_house_name'),
            'clear_house_user' => $request->get('clear_house_user'),
            'clear_house_password' => $request->get('clear_house_password'),
            'pay_address' => $request->get('pay_address'),
            'pay_city' => $request->get('pay_city'),
            'pay_state' => $request->get('pay_state'),
            'pay_zip' => $request->get('pay_zip'),
            'pay_fax' => $request->get('pay_fax'),
            'pay_phone' => $request->get('pay_phone'),
            'pay_county' => $request->get('pay_county'),
            'bill_address' => $request->get('bill_address'),
            'bill_city' => $request->get('bill_city'),
            'bill_state' => $request->get('bill_state'),
            'bill_zip' => $request->get('bill_zip'),
            'bill_fax' => $request->get('bill_fax'),
            'bill_phone' => $request->get('bill_phone'),
            'bill_county' => $request->get('bill_county'),
            'contact1_name' => $request->get('contact1_name'),
            'contact1_email' => $request->get('contact1_email'),
            'contact1_phone' => $request->get('contact1_phone'),
            'contact1_mobile' => $request->get('contact1_mobile'),
            'owner_name' => $request->get('owner_name'),
            'onwer_email' => $request->get('onwer_email'),
            'owner_phone' => $request->get('owner_phone'),
            'owner_mobile' => $request->get('owner_mobile'),
        ]);

        $practice->plocations()->delete();
        if (($request->get('service_address'))) {
            foreach ($request->get('service_address') as $key => $address) {
                if($address["service_address"]==""){
                    continue;
                }
                
                $plocation = new Plocation;
                $plocation->practice_id = $practice->id;
                $plocation->service_address = $address["service_address"];
                $plocation->service_city = $address["service_city"];
                $plocation->service_county = $address["service_county"];
                $plocation->service_fax = $address["service_fax"];
                $plocation->service_phone = $address["service_phone"];
                $plocation->service_state = $address["service_state"];
                $plocation->service_zip =$address["service_zip"];
                
                $plocation->save();
            }
        }

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

        $practice->update($request->except('service_address','id'));
        // $practice->update($request->all());
        $practice->plocations()->delete();
        if (($request->get('service_address'))) {
            foreach ($request->get('service_address') as $key => $address) {
                if($address["service_address"]==""){
                    continue;
                }
                
                $plocation = new Plocation;
                $plocation->practice_id = $practice->id;
                $plocation->service_address = $address["service_address"];
                $plocation->service_city = $address["service_city"];
                $plocation->service_county = $address["service_county"];
                $plocation->service_fax = $address["service_fax"];
                $plocation->service_phone = $address["service_phone"];
                $plocation->service_state = $address["service_state"];
                $plocation->service_zip =$address["service_zip"];
                
                $plocation->save();
            }
        }
        $practice->plogins()->delete();
        if (($request->get('web_portals'))) {
            foreach ($request->get('web_portals') as $key => $portal) {
                if($portal["loginweb"]=="" && $portal["loginuser"]==""){
                    continue;
                }
                
                $login = new Plogin;
                $login->practice_id = $practice->id;
                $login->loginweb = $portal["loginweb"];
                $login->loginuser = $portal["loginuser"];
                $login->loginpass = $portal["loginpass"];
                $login->additional_information = $portal["additional_information"];
                $login->save();
            }
        }

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
    public function getPracticeProvider($id) {
        $providers=array();
//        $practice = $this->practice->findOrFail($id);
        $practice = Practice::findOrFail($id);
        
        if($practice){
            $providers = $practice->providers()->get(['providers.id','full_name','individual_npi']);
        }
        
        return compact('providers','practice');
    }
}
