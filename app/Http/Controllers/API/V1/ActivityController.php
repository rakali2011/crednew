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
            'provider_id' => '',
            'payer' => '',
            'action' => 'required',
            'description' => 'required|min:3',
        ]);
//dd($validatedData);
        $activity = new Activity;

        $provider = \App\Models\Provider::find($validatedData['provider_id']);

        $activity->provider_name = $provider ? $provider->full_name : "N/A";
        $activity->payer = $validatedData['payer']?$validatedData['payer']:"N/A" ;
        $activity->user = auth()->user()->name;
        $activity->user_id = auth()->user()->id;
        $activity->email = auth()->user()->email;
        $activity->action = $validatedData['action'];
        $activity->description = $validatedData['description'];

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
}
