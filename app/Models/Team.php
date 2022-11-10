<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;
    protected  $table = "teams";
    protected $guarded = ['id'];

    public function assigned_users() {
        return $this->belongsToMany(User::class,'team_user','user_id','team_id');
    }
    // public function users() {
    //     return $this->belongsToMany('App\User');
    // }
}
