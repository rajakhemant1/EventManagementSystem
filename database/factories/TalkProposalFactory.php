<?php


namespace Database\Factories;

use App\Models\TalkProposal;
use App\Models\Speaker;
use Illuminate\Database\Eloquent\Factories\Factory;

class TalkProposalFactory extends Factory
{
    protected $model = TalkProposal::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'speaker_id' => Speaker::factory(), // Associate with a speaker by creating one
        ];
    }
}
