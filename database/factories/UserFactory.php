<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // Default password for testing
            'role' => 'speaker', // Default role
        ];
    }

    /**
     * State to define a user as a reviewer.
     */
    public function reviewer()
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'reviewer',
        ]);
    }
}
