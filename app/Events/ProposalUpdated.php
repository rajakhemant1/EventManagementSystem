<?php

namespace App\Events;

use App\Models\TalkProposal;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProposalUpdated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $talkProposal;
    public $action;  // Add this property to store the action type

    /**
     * Create a new event instance.
     *
     * @param TalkProposal $talkProposal
     * @param string $action
     */
    public function __construct(TalkProposal $talkProposal, string $action)
    {
        $this->talkProposal = $talkProposal;
        $this->action = $action;  // Set the action type
    }

    public function broadcastOn()
    {
        return new Channel('proposals');
    }

    public function broadcastAs()
    {
        return 'proposal.updated';
    }
}
