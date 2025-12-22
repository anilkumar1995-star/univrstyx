<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateList extends Model
{
    protected $table = 'states'; 
    protected $fillable = ['stateid', 'statename'];
    public $timestamps = false;
}
