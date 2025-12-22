<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';
    protected $fillable = [
        'user_id',
        'course_id',
        'prefix',
        'name',
        'father_name',
        'guardian_name',
        'gender',
        'dob',
        'phone',
        'email',
        'city',
        'bachelor',
        'bachelor_percentage',
        'masters',
        'masters_percentage',
        'experience',
        'organisation',
        'designation',
        'industry',
        'payment_status',
        'referral_code',
    ];


    // protected $casts = [
    //     'step_data' => 'array',
    // ];

    public $with = ['course'];

    public function course()
    {
        return $this->belongsTo(University::class, 'course_id', 'id');
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }
}
