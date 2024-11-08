<?php

namespace Database\Factories;

use App\Models\Revision;
use App\Models\User;
use App\Models\Speaker;
use Illuminate\Database\Eloquent\Factories\Factory;

class RevisionFactory extends Factory
{
    protected $model = Revision::class;

    public function definition()
    {
        return [
            'revisable_id' => null,                  // This will be set when attaching to a specific model
            'revisable_type' => null,                // This will be set when attaching to a specific model type
            'user_id' => Speaker::factory(),            // Creates an associated user for the revision
            'changes' => $this->faker->text(100),    // Simulates change information
            'created_at' => now()
        ];
    }
}
