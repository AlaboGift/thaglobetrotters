<?php

namespace App\Models\General;

use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Color extends Model
{
    use HasFactory, SoftDeletes, Filter;

    protected $table = 'colors';
    protected $guarded = ['id'];
}