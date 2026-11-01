<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['title', 'description', 'badge_one', 'badge_two', 'icon', 'sort_order'];
}
