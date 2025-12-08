<?php

namespace App\Models;
use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory, Filter;

    protected $guarded = ['id'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
