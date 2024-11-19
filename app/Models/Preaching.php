<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Preaching extends Model
{
    use SoftDeletes,HasFactory;
    protected $table = 'preachings';
    protected  $fillable = [
        'title',
        'description',
        'audio_url',
        'preacher',
        'church_id'
    ];
    /**
     * @return BelongsTo
     */
    public function church(): BelongsTo
    {
        return $this->belongsTo(Church::class,'church_id');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'preaching_follows');
    }

    // Relation avec les vues (écoutes) des utilisateurs
    public function views():HasMany
    {
        return $this->hasMany(PreachingFollow::class);
    }
}
