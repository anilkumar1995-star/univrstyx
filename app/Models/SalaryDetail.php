<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class SalaryDetail extends Model
{
    protected $table = 'salary_details';

    protected $fillable = ['emp_id', 'basic_salary', 'hra', 'da', 'pf', 'gross_salary', 'net_salary', 'ctc', 'joining'];

    public $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'emp_id', 'agentcode');
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
