<?php

namespace App\Models\General;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'states';

    protected $guarded = ['id'];

    const DEFAULT = 2679;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'state_id', 'id');
    }

    public function scopeOnlyNigeria($query)
    {
        return $query->where('country_id', Country::DEFAULT);
    }


    public function images()
	{
		return $this->morphMany(Image::class, 'imageable');
	}

	public function getImage()
	{
		return $this->images()->latest()->first();
	}
}
