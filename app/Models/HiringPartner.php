<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class HiringPartner extends Model
{
    protected $table = 'hiring_company';

    protected $fillable =[
        'user_id', 'company_name', 'company_image', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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

       