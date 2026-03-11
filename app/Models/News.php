<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'section_id',
        'user_id',
        'status_id',
        'title',
        'slug',
        'content',
        'image',
        'published_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (News $news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }

            // Asignamos autor por defecto si no llega en el request
            if (empty($news->user_id)) {
                $news->user_id = auth()->id();
            }

            // Si el status es "published" y no tiene published_at, lo asignamos
            if ($news->status && $news->status->slug === 'publicado' && empty($news->published_at)) {
                $news->published_at = now();
            }
        });

        static::updating(function (News $news) {
            // Si cambia a publicado y aún no tiene fecha, la registramos
            if ($news->isDirty('status_id')) {
                $status = Status::find($news->status_id);
                if ($status && $status->slug === 'publicado' && empty($news->published_at)) {
                    $news->published_at = now();
                }
            }
        });
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereHas('status', fn ($q) => $q->where('slug', 'publicado'));
    }

    public function scopeBySection(Builder $query, int|string $section): Builder
    {
        return $query->whereHas('section', function ($q) use ($section) {
            is_int($section)
                ? $q->where('id', $section)
                : $q->where('slug', $section);
        });
    }

    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
