<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PreachingFollow extends Model
{
    protected $fillable = ['user_id', 'preaching_id'];
}
