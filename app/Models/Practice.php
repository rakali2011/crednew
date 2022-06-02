<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Practice extends Model
{
    use HasFactory, SoftDeletes;
protected  $table = "practices";

/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    public function providers(){
        return $this->belongsToMany(Provider::class,'practice_providers');
    }
    public function documents() {
        return $this->hasMany(Practicedoc::class)->with('document_type');
    }
    public function plocations() {
        return $this->hasMany(Plocation::class);
    }
    public function plogins() {
        return $this->hasMany(PLogin::class);
    }
}
