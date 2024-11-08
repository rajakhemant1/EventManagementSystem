<?php

namespace Tests\Unit;

use App\Models\TalkProposal;
use App\Models\Tag;
use App\Models\Speaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TalkProposalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_speaker()
    {
        // Create a speaker and associate a talk proposal with them
        $speaker = Speaker::factory()->create();
        $proposal = TalkProposal::factory()->create(['speaker_id' => $speaker->id]);

        // Assert that the proposal's speaker is the created speaker
        $this->assertInstanceOf(Speaker::class, $proposal->speaker);
        $this->assertEquals($speaker->id, $proposal->speaker->id);
    }

    /** @test */
    public function it_can_have_multiple_tags()
    {
        // Create a talk proposal and tags
        $proposal = TalkProposal::factory()->create();
        $tags = Tag::factory(3)->create();

        // Attach tags to the proposal
        $proposal->tags()->attach($tags);

        // Assert that the proposal has the tags associated with it
        $this->assertCount(3, $proposal->tags);
        foreach ($tags as $tag) {
            $this->assertTrue($proposal->tags->contains($tag));
        }
    }

    /** @test */
    public function it_has_required_attributes()
    {
        // Create a talk proposal
        $proposal = TalkProposal::factory()->create([
            'title' => 'Sample Talk',
            'description' => 'This is a sample description.'
        ]);

        // Assert that the attributes were saved correctly
        $this->assertEquals('Sample Talk', $proposal->title);
        $this->assertEquals('This is a sample description.', $proposal->description);
    }

    /** @test */
    public function it_can_attach_and_detach_tags()
    {
        $proposal = TalkProposal::factory()->create();
        $tag = Tag::factory()->create();

        // Attach the tag to the proposal
        $proposal->tags()->attach($tag);
        $this->assertTrue($proposal->tags->contains($tag));

        // Detach the tag and reload the relationship
        $proposal->tags()->detach($tag);
        $proposal->load('tags');

        // Assert that the tag is now detached
        $this->assertFalse($proposal->tags->contains($tag));
    }

    /** @test */
    public function it_can_filter_by_tags_using_scope()
    {
        // Create proposals with specific tags
        $proposalWithTag = TalkProposal::factory()->create();
        $tag = Tag::factory()->create(['name' => 'Technology']);
        $proposalWithTag->tags()->attach($tag);

        // Filter proposals by the 'Technology' tag
        $filteredProposals = TalkProposal::withTags(['Technology'])->get();

        // Assert that the filtered proposal is included in the results
        $this->assertTrue($filteredProposals->contains($proposalWithTag));
    }
}
