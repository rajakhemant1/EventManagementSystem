<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\RecordsRevisions;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Speaker extends Authenticatable
{
    use Notifiable,RecordsRevisions,HasFactory;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function revisions()
{
    return $this->morphMany(Revision::class, 'revisable');
}
}


