<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'languages';

    protected $guarded = ['id'];
}
