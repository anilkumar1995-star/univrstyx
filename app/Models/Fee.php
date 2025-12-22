<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Fee extends Model
{
    protected $table = 'fees';

      protected $fillable = ['user_id','type','student_unique_id','student_name','dob','father_name',
        'mother_name','mobile','email','college_name','hostel_name','room_number','session_year','amount',
        'exam_name'
    ];

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }
}
