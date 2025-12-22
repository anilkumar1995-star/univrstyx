<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ContactList extends Model
{
    protected $table = 'contact_list';

    protected $fillable = ['name', 'email', 'mobile', 'about', 'avatar', 'is_visible', 'status', 'group_id', 'user_id'];

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

}
