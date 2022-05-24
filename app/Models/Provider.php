<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Provider extends Model
{
    use HasFactory, SoftDeletes;
protected $table = "providers";
    protected $guarded = [];
    
    public function practices(){
        return $this->belongsToMany(Practice::class,'practice_providers');
    }
    public function payers() {
        return $this->belongsToMany('App\Models\Payer')->withPivot('provider_identifier', 'effective_date', 'status', 'business_line', 'business_effective_date', 'created_at', 'updated_at');
    }
    public function documents() {
        return $this->hasMany(Document::class)->with('document_type');
    }
    public function logins() {
        return $this->hasMany(Login::class);
    }
}
