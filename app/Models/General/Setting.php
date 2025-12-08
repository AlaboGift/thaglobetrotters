<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function scopeNoneSensitive($query)
    {
        return $query->whereNotIn('key', ['flutterwave_public_key', 'flutterwave_secret_key', 'paystack_public_key', 'paystack_secret_key']);
    }
}
