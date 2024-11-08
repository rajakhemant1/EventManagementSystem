<?php

namespace Tests\Feature;

use App\Models\Speaker; // Use the Speaker model
use App\Models\TalkProposal;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TalkProposalControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_speaker_can_view_their_talk_proposals()
    {
        // Create a speaker instance
        $speaker = Speaker::factory()->create();

        // Authenticate as the speaker
        $this->actingAs($speaker, 'speaker');

        // Access the index route for talk proposals
        $response = $this->get(route('talk-proposals.index'));
        
        // Assert successful access
        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_speaker_can_access_create_proposal_page()
    {
        // Create a speaker instance
        $speaker = Speaker::factory()->create();

        // Authenticate as the speaker using the 'speaker' guard
        $this->actingAs($speaker, 'speaker');

        // Access the create route for talk proposals
        $response = $this->get(route('talk-proposals.create'));

        // Assert that the page loads successfully
        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_speaker_can_create_a_talk_proposal()
    {
        Storage::fake('public');

        // Create a speaker instance
        $speaker = Speaker::factory()->create();
        $this->actingAs($speaker, 'speaker');

        // Create a tag for the proposal
        $tag = Tag::factory()->create();

        // Define the data, including the CSRF token
        $data = [
            '_token' => csrf_token(), // Manually include the CSRF token
            'title' => 'New Talk',
            'description' => 'Description of the talk.',
            'file' => UploadedFile::fake()->create('presentation.pdf', 1024, 'application/pdf'),
            'tags' => [$tag->id],
        ];

        // Submit the form to create a new talk proposal
        $response = $this->post(route('talk-proposals.store'), $data);

        // Assert redirection to the index page
        $response->assertRedirect(route('talk-proposals.index'));

        // Check that the talk proposal exists in the database
        $this->assertDatabaseHas('talk_proposals', ['title' => 'New Talk']);
        Storage::disk('public')->assertExists("proposals/{$data['file']->hashName()}");
    }


    /** @test */
    // public function unauthenticated_user_is_redirected_when_trying_to_create_talk_proposal()
    // {
    //     // Access the create route without authentication
    //     $response = $this->get(route('talk-proposals.create'));

    //     // Assert redirection to login page
    //     $response->assertRedirect(route('speaker.login'));
    // }

    /** @test */
    public function show_view_displays_talk_proposal_details()
    {
        // Create a speaker instance
        $speaker = Speaker::factory()->create();

        // Authenticate as the speaker
        $this->actingAs($speaker, 'speaker');

        // Create a talk proposal associated with the speaker
        $proposal = TalkProposal::factory()->create(['speaker_id' => $speaker->id]);

        // Access the show route for the specific talk proposal
        $response = $this->get(route('talk-proposals.show', $proposal->id));

        // Assert successful access
        $response->assertStatus(200);

        // Verify that the view displays the proposal details
        $response->assertViewIs('talk_proposals.show');
        $response->assertSee($proposal->title);
        $response->assertSee($proposal->description);
    }
}
