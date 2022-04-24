<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practicedoc extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected $table = 'practicedocs';
    
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
