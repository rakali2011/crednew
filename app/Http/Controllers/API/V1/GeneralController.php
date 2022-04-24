<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Provider;
use App\Models\Payer;
use App\Models\Payer_provider;
use Illuminate\Http\Request;

class GeneralController extends BaseController {

    public function __construct() {
        $this->middleware('auth:api');
    }

    public function dashboard_counts() {
        $dashboard_counts = array();
        $providers = Provider::where('deleted_at', null)->count();
        $payers = Payer::where('deleted_at', null)->count();

        $dashboard_counts["total_providers"] = $providers;
        $dashboard_counts["total_payers"] = $payers;
        $dashboard_counts["total_documents"] = \App\Models\Document::where('deleted_at', null)->count();
        $dashboard_counts["total_users"] = \App\Models\User::count();
        $dashboard_counts["total_practices"] = \App\Models\Practice::where('deleted_at', null)->count();

        $provider_ids = array();
        $providers = Provider::select('providers.id')->get();
        foreach ($providers as $provider):
            $provider_ids[] = $provider->id;
        endforeach;
        $dashboard_counts['participating'] = Payer_provider::
                        where('status', '=', 'participating')
                        ->whereIn('provider_id', $provider_ids)->count();
        $dashboard_counts['non_participating'] = Payer_provider::
                        where('status', '=', 'non-participating')
                        ->whereIn('provider_id', $provider_ids)->count();
        $dashboard_counts['in_process'] = Payer_provider::
                        where('status', '=', 'in-process')
                        ->whereIn('provider_id', $provider_ids)->count();
        $dashboard_counts['pending_prg'] = Payer_provider::
                        where('status', '=', 'pending-prg')
                        ->whereIn('provider_id', $provider_ids)->count();
        $dashboard_counts['pending_provider'] = Payer_provider::
                        where('status', '=', 'pending-provider')
                        ->whereIn('provider_id', $provider_ids)->count();
        $dashboard_counts['rejected'] = Payer_provider::
                        where('status', '=', 'rejected')
                        ->whereIn('provider_id', $provider_ids)->count();
        $dashboard_counts['not_eligible'] = Payer_provider::
                        where('status', '=', 'not-eligible')
                        ->whereIn('provider_id', $provider_ids)->count();
        $dashboard_counts['panel_closed'] = Payer_provider::
                        where('status', '=', 'panel-closed')
                        ->whereIn('provider_id', $provider_ids)->count();
        $dashboard_counts['approved'] = Payer_provider::
                        where('status', '=', 'approved')
                        ->whereIn('provider_id', $provider_ids)->count();

        return $this->sendResponse($dashboard_counts, 'Dashboard count list');
    }

}
