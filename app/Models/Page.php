<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'footer_section', 'is_published'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}
