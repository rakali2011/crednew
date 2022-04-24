<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Payer;
use App\Models\Provider;
use App\Models\Remark;
use Illuminate\Http\Request;

class RemarkController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function all(Request $request) {
        
        $remark = new Remark;
        $remarks = $remark->getRemarks($request->pro_id,$request->pay_id);
        
        return $this->sendResponse($remarks, 'Remarks list');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Remark  $remark
     * @return \Illuminate\Http\Response
     */
    public function show(Remark $remark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Remark  $remark
     * @return \Illuminate\Http\Response
     */
    public function edit(Remark $remark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Remark  $remark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Remark $remark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Remark  $remark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $remark = Remark::find($request->remark_id);
        if($remark->update(['deleted' => 1])){
            return 1;
        }else{
            return 0;
        }

    }
}
