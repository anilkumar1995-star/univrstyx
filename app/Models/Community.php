<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $table = 'community';
    protected $fillable = [
        'user_id',
        'title',
        'subtitle',
        'feature_categories',
        'trending_discussions',
        'contributors',
        'feature_heading',
        'trending_heading',
        'top_contributer_heading',
        'cta_title',
        'cta_subtitle',
        'cta_button_text',
        'status',
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
