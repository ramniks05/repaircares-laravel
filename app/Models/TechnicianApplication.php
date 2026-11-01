<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TechnicianApplication extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'city_id',
        'address',
        'profile_photo',
        'aadhar_number',
        'aadhar_document',
        'pan_number',
        'pan_document',
        'work_experience',
        'work_categories',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'work_categories' => 'array',
        ];
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function documentUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return asset('storage/'.$path);
    }
}
