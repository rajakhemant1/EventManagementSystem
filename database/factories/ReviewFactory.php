<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\TalkProposal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'reviewer_id' => User::factory()->reviewer(), // Creates a User with role "reviewer"
            'talk_proposal_id' => TalkProposal::factory(), // Creates an associated talk proposal
            'comments' => $this->faker->sentence,
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
