<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'url',
        'target',
        'css_classes',
        'icon',
        'order',
        'is_active',
        'meta',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'meta' => 'array',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    public function activeChildren(): HasMany
    {
        return $this->children()->where('is_active', true);
    }

    public function toTreeArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'target' => $this->target,
            'css_classes' => $this->css_classes,
            'icon' => $this->icon,
            'order' => $this->order,
            'is_active' => $this->is_active,
            'meta' => $this->meta,
            'children' => $this->activeChildren->map(function ($child) {
                return $child->toTreeArray();
            })->toArray(),
        ];
    }

    public function getUrlAttribute($value)
    {
        if ($value && !str_starts_with($value, 'http') && !str_starts_with($value, '/') && !str_starts_with($value, '#')) {
            return '/' . $value;
        }
        return $value;
    }

    public static function getRootItems(int $menuId)
    {
        return static::where('menu_id', $menuId)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }
}