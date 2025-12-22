<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TeamMember extends Model
{
    protected $table = 'team_members';

    protected $fillable = ['user_id', 'team_id'];


    public $with = ['user', 'department', 'team'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
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
