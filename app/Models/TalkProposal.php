<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsRevisions;

class TalkProposal extends Model
{
    use HasFactory,RecordsRevisions;

    protected $fillable = [
        'speaker_id',
        'title',
        'description',
        'file_path',
    ];

    // Define relationship with Speaker
    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }

    public function revisions()
    {
        return $this->morphMany(Revision::class, 'revisable');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeWithTags($query, $tags)
    {
        return $query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('name', $tags);
        });
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
