<?php

namespace App\Traits;

use App\Models\Revision;
use Illuminate\Support\Facades\Auth;

trait RecordsRevisions
{
    public static function bootRecordsRevisions()
    {
        static::updated(function ($model) {
            $model->recordRevision();
        });
    }

    public function recordRevision()
    {
        $original = $this->getOriginal();
        $changes = $this->getDirty(); // Only the changed attributes

        // Filter out unchanged or irrelevant fields if necessary
        if (!empty($changes)) {
            $this->revisions()->create([
                'changes' => $changes,
                'user_id' => Auth::id(),
                'created_at' => now(),
            ]);
        }
    }
}
