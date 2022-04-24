<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected $table = 'documents';
    
    public function provider(){
        return $this->belongsTo(Provider::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function document_type(){
        return $this->belongsTo(Document_type::class);
    }
}
