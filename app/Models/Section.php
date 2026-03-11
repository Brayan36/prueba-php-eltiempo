<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Section extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected static function booted(): void
    {
        static::creating(function (Section $section) {
            if (empty($section->slug)) {
                $section->slug = Str::slug($section->name);
            }
        });
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'section_id', 'id');
    }
}
