<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // protected $with = ['user'];

    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
