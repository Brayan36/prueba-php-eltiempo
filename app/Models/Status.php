<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Status extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function booted(): void
    {
        static::creating(function (Status $status) {
            if (empty($status->slug)) {
                $status->slug = Str::slug($status->name);
            }
        });
    }

    // Consultas creadas para simplificar el llamado en controlador
    public static function draft(): self
    {
        return self::where('slug', 'borrador')->firstOrFail();
    }

    public static function published(): self
    {
        return self::where('slug', 'publicado')->firstOrFail();
    }

    public static function archived(): self
    {
        return self::where('slug', 'archivado')->firstOrFail();
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'status_id', 'id');
    }
}
