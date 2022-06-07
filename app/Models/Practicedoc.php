<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Practicedoc extends Model
{
    // use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $dates = [ 'deleted_at' ];
    
    protected $table = 'practicedocs';
    protected $softDelete = true;
    
    public function practice(){
        return $this->belongsTo(Practice::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function document_type(){
        return $this->belongsTo(Document_type::class);
    }
}
