<?php

namespace App\Models\General;
use App\Observers\ImageObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ImageObserver::class])]
class Image extends Model
{
    use HasFactory;

    protected $table = 'images';
    protected $guarded = ['id'];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }


    public function getURL()
    {
            $imageUrl = $this->attributes['url'] ?? null;
            $name = $this->attributes['name'] ?? 'Guest';
        
            return !is_null($imageUrl) && $imageUrl != 'NULL'
                ? asset('public/assets/'.$imageUrl) 
                : 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
    }
}
