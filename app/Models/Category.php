<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsTo;
=======
>>>>>>> mainpage
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
<<<<<<< HEAD
    protected $primaryKey = 'category_id';

    const CATEGORY_ID = 'category_id';
    const CATEGORY_NAME = 'name';
    const CATEGORY_SLUG = 'slug';
    const PARENT_ID = 'parent_id';
    const CATEGORY_ACTIVE = 'category_active';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'parent_id',
        'category_active',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'category_active' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
=======
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }
}
>>>>>>> mainpage
