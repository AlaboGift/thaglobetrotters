<?php

namespace App\Models\General;
use App\Models\Package;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    use HasFactory, Filter;

    protected $table = 'categories';
    protected $guarded = ['id'];

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function getImageUrlAttribute()
    {
        $imageUrl = $this->attributes['image_url'] ?? null;

        return !is_null($imageUrl) && $imageUrl != 'NULL'
            ? asset('public/assets/'.$imageUrl) 
            : url('public/admin/assets/img/elements/default.png');
    }

    public function packages()
    {
        return $this->hasMany(Package::class, 'category_id');
    }
}