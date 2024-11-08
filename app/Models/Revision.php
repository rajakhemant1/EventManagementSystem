<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Revision extends Model
{
    use HasFactory;
    protected $fillable = ['revisable_id', 'revisable_type', 'changes', 'user_id', 'created_at'];

    protected $casts = [
        'changes' => 'array',
    ];

    public $timestamps = false; // We’re only using `created_at` to track changes

    // Polymorphic relationship
    public function revisable()
    {
        return $this->morphTo();
    }
}
