<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Church extends Model
{
    use SoftDeletes, HasFactory, HasUuids;
    protected $fillable = [
        'name',
        'abbreviation',
        'address',
        'phone',
        'email',
        'logo',
        'city',
        'state',
        'country',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function preachings(): HasMany
    {
        return $this->hasMany(Preaching::class);
    }
    public function followers(): HasMany
    {
        return $this->hasMany(Follower::class);
    }
}
