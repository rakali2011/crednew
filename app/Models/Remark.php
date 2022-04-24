<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    use HasFactory;
        public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function getRemarks($pro_id, $pay_id) {
        $query = $this;
        
//        $query->select('remarks',DB::raw("DATE_FORMAT(created_at, '%a %b %e, %Y %h:%i %p') as date"),'user_id');
        return $query->where('payer_id', '=', $pay_id)
                ->where('provider_id', '=', $pro_id)
                ->where('deleted', 0)
                ->orderBy('created_at', 'DESC')->get()->load('user');
        
    }
}
