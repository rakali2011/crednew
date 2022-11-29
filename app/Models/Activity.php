<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    
    public function count_activities($date_range, $filter) {
        $query = $this;
        return $query->count();
}
    
    public function getActivities($filter) {
        $query = $this;
        $search = $filter["search"];
        $start = $filter["start"];
        $limit = $filter["limit"];

        if (!empty($search)) {
            return $query->where(function($query) use ($search) {
                                $query->where('practice_name', 'LIKE', "%{$search}%");
                                $query->orWhere('provider_name', 'LIKE', "%{$search}%");
                                $query->orWhere('payer', 'LIKE', "%{$search}%");
                                $query->orWhere('user', 'LIKE', "%{$search}%");
                                $query->orWhere('email', 'LIKE', "%{$search}%");
                                $query->orWhere('enrollment_credentialing', 'LIKE', "%{$search}%");
                                $query->orWhere('era_eft_edi_portal', 'LIKE', "%{$search}%");
                                $query->orWhere('initiated_followup', 'LIKE', "%{$search}%");
                                $query->orWhere('reference_no', 'LIKE', "%{$search}%");
                                $query->orWhere('initiated_date', 'LIKE', "%{$search}%");
                                $query->orWhere('followup_date', 'LIKE', "%{$search}%");
                                $query->orWhere('user', 'LIKE', "%{$search}%");
                            })
                            ->offset($start)
                            ->limit($limit)
                            ->get();
        }else{
            return $query->offset($filter["start"])->limit($filter["limit"])->get();
        }        
}
}