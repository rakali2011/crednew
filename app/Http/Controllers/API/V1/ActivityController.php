<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends BaseController
{
    protected $activity = '';
    public function __construct(Activity $activity)
    {
        $this->middleware('auth:api');
        $this->activity = $activity;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'selected_practices' => '',
            'provider_id' => 'required',
            'payer' => 'required',
            'enrollment_credentialing' => 'required',
            'era_eft_edi_portal' => '',
            'initiated_followup' => 'required',
            'initiated_date' => '',
            'followup_date' => '',
            'reference_no' => 'required',
            'description' => 'required|min:3',
        ]);
//dd($validatedData);
        $activity = new Activity;

        $provider = \App\Models\Provider::find($validatedData['provider_id']);
        $practice = \App\Models\Practice::find($validatedData['selected_practices']);

        $activity->practice_name = $practice ? $practice->practice_name : "N/A";
        $activity->provider_name = $provider ? $provider->full_name : "N/A";
        $activity->payer = $validatedData['payer']?$validatedData['payer']:"N/A" ;
        $activity->enrollment_credentialing = $validatedData['enrollment_credentialing'] ;
        $activity->era_eft_edi_portal = $validatedData['era_eft_edi_portal'] ;
        $activity->initiated_followup = $validatedData['initiated_followup'] ;
        $activity->initiated_date = $validatedData['initiated_date'] ;
        $activity->followup_date = $validatedData['followup_date'] ;
        $activity->reference_no = $validatedData['reference_no'] ;
        $activity->user = auth()->user()->name;
        $activity->user_id = auth()->user()->id;
        $activity->email = auth()->user()->email;
//        $activity->action = $validatedData['action'];
        $activity->description = $validatedData['description'];
        $activity->submitted_at = date("m-d-Y");

        $activity->save();
        return $this->sendResponse($activity, 'Activity Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }
    public function allUsersActivity(Request $request){
        
        $activities = $this->activity->get();
//        dd($apps->count());
        return $this->sendResponse($activities, 'Activity list');
    }
    public function allUsersActivityNew(Request $request){
        
        $recordsTotal = $this->activity->count();
        $start = $request->input('page');
        $length = $request->input('pageSize');
        $search = $request->input('search');

        $start = ($start * $length) - $length;
        if($start<0){
            $start=0;
        }
        
        $limit = $length;
        if($limit<0){
            $limit=9999999;
        }
        $filter = array(
            "start" => $start,
            "limit" => $limit,
            "search" => $search,
        );

        $activities = $this->activity->getActivities($filter);

//        dd($apps->count());
        $recordsFiltered = $recordsTotal;
        $json_data = array(
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $activities
        );

        return $this->sendResponse($json_data, 'Activity list');
    }
}
