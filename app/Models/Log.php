<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['user'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
    }
}
