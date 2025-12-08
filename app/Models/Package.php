<?php

namespace App\Models;

use App\Enums\Status;
use App\Models\General\Category;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\General\Image;
use App\Models\General\Review;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Package extends Model
{
    use HasFactory, Filter;

    protected $guarded = ['id'];

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }


    public function getImage()
    {
        return $this->images()->latest()->first();
    }

    public function getImageUrl()
    {
        return $this->getImage() ? $this->getImage()->getURL() : url('/admin/assets/img/elements/default.png');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', Status::ACTIVE);
    }

    public function url()
    {
        return url("/trip/{$this->slug}");
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
