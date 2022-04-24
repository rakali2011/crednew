<?php

namespace App\Http\Controllers\API\V1;
use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\Remark;
class QuickupdateController extends BaseController
{
    //
        /**
     * Create a new controller instance.
     *
     * @return void
     */
        public function __construct()
    {
        $this->middleware('auth:api');
    }
    
 

    public function update(Request $request)
    {
        
        $validatedData = $request->validate([
            'provider_id' => 'required|integer',
            ]);
        $provider = Provider::find($request->provider_id);
        $payer_id_array=array();
        $applications = $request->applications;
        
        $data = json_decode($request->applications);
        foreach($data as $app) {
            $effective_date = $app->appeffective_date ? date('Y-m-d', strtotime($app->appeffective_date)):NULL;
      $payer_id_array[$app->app_name] = ['status' => $app->appstatus, 'effective_date' => $effective_date, 'provider_identifier' => $app->provider_identifier];
      if (!empty($app->app_remarks)) {
                    $remark = new Remark;
                    $remark->provider_id = $request->provider_id;
                    $remark->payer_id = $app->app_name;
                    $remark->remarks = $app->app_remarks;
                    $remark->user_id = auth()->user()->id;
                    $remark->save();
      }
    }
        
        
        $provider->payers()->sync($payer_id_array, TRUE);
        return $this->sendResponse($provider, 'Application has been updated');

    }

}
