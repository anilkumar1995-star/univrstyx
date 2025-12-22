<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Department extends Model
{
    protected $table = 'department';

    protected $fillable = ['department_name'];

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

}
