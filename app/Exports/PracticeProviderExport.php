<?php

namespace App\Exports;
use App;
use App\Practice;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PracticeProviderExport implements FromView {

    protected $practice_id;

    function __construct($practice_id) {
        $this->practice_id = $practice_id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View {
        
        $result = app(App\Http\Controllers\API\V1\PracticeController::class)->getPracticeProvider($this->practice_id);
        $pros = array();

        foreach($result["providers"] as $provider){
            
            $result2 = app(App\Http\Controllers\API\V1\ProviderController::class)->getProviderPayer($provider->id);
            $pros[] = $result2["provider"];
            
        }
        $practice_providers = app(App\Http\Controllers\API\V1\PracticeController::class)->getPracticeProvider($this->practice_id);
//        dd($practice_providers["practice"]);
//        dd($pros);

        return view('exports.practice_provider', [
            "practice"=>$practice_providers["practice"],
            "providers"=>$pros,
        ]);
    }

}
