<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LearnerSupport extends Model
{
    protected $table = 'learner_support';

    protected $fillable = ['user_id', 'learner_support_heading', 'learner_support_content','get_started', 'status'];


    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

}
