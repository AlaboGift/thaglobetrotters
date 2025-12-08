<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'countries';

    protected $guarded = ['id'];

    const DEFAULT = 160;

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function getCurrency()
    {
        return $this->currency_code;
    }

    public function getExchangeRate()
    {
        return $this->exchange_rate / 100;
    }

    public function scopeHasExchangeRate($query)
    {
        return $query->whereNotNull('exchange_rate');
    }
}
