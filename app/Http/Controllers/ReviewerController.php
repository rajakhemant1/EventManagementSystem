<?php

namespace App\Http\Controllers;

use App\Models\TalkProposal;
use App\Models\Review;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ProposalReviewedNotification;


class ReviewerController extends Controller
{
    /**
     * Display the dashboard with filters and search options for talk proposals.
     */
  
     public function dashboard(Request $request)
    {
        $search = $request->input('search');
        $tagId = $request->input('tag');
        $speakerName = $request->input('speaker_name');
        $dateSubmitted = $request->input('date_submitted');

        $tags = Tag::all();

        $query = TalkProposal::with(['tags', 'reviews', 'speaker']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($tagId) {
            $query->whereHas('tags', function ($q) use ($tagId) {
                $q->where('tags.id', $tagId);  // Explicitly specify 'tags.id'
            });
        }

        if ($speakerName) {
            $query->whereHas('speaker', function ($q) use ($speakerName) {
                $q->where('name', 'like', '%' . $speakerName . '%');
            });
        }

        if ($dateSubmitted) {
            $query->whereDate('created_at', $dateSubmitted);
        }
        $query->orderBy("id","desc");
        $talkProposals = $query->paginate(10);

        return view('reviewers.dashboard', compact('talkProposals', 'tags', 'search', 'tagId', 'speakerName', 'dateSubmitted'));
    }

    /**
     * Store or update a review for a talk proposal.
     */
    public function storeReview(Request $request, $talkProposalId)
    {
        try {

            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
               
                'comments' => 'nullable|string',
                'rating' => 'required|integer|min:1|max:5',

            ]);
     
            if ($validator->fails()) {
                $request->session()->flash('error', $validator->messages()->all()[0]);
                return back()
                    ->withErrors($validator)
                    ->withInput();


            }

            Review::updateOrCreate(
                [
                    'reviewer_id' => Auth::id(),
                    'talk_proposal_id' => $talkProposalId,
                ],
                [
                    'comments' => $request->input('comments'),
                    'rating' => $request->input('rating'),
                ]
            );
            $this->updateProposalStatus($talkProposalId);
            $talkProposal = TalkProposal::with('speaker')->find($talkProposalId);

            // Send notification to the speaker
            $talkProposal->speaker->notify(new ProposalReviewedNotification($talkProposal));
    
            DB::commit();
            return redirect()->route('reviewer.dashboard')->with('success', 'Review submitted successfully.');
        } catch (\Exception $e) {           
            DB::rollback();           
            return redirect()->back()->with('error',  $e->getMessage());           
           
        }
    }

    private function updateProposalStatus($talkProposalId)
    {
        try {

            $talkProposal = TalkProposal::find($talkProposalId);
    
            // Calculate the average rating for the proposal
            $averageRating = $talkProposal->reviews()->avg('rating');
            
            // Determine the status based on average rating
            if ($averageRating >= 4) {
                $talkProposal->status = 'approved';
            } elseif ($averageRating >= 2) {
                $talkProposal->status = 'under review';
            } else {
                $talkProposal->status = 'rejected';
            }
    
            // Save the updated status
            $talkProposal->save();
        } catch (\Exception $e) {           
            throw new \Exception( $e->getMessage(), 1);   
           
        }
    }

}
