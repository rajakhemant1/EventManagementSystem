<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TalkProposal;
use App\Models\Review;
use Illuminate\Http\Request;
use DB;

class TalkProposalController extends Controller
{
    /**
     * Get all reviews for a specific talk proposal.
     *
     * @param  int  $id
     */
    public function getReviews($id)
    {
        try {

            $reviews = Review::where('talk_proposal_id', $id)
            ->with('reviewer:id,name')  // Include reviewer info
            ->get(['id', 'reviewer_id', 'comments', 'rating']);

            if ($reviews->isEmpty()) {
                return response()->json([
                'success' => false,
                'message' => 'No reviews found for this proposal.'
                ], 404);
            }

            return response()->json([
            'success' => true,
            'data' => $reviews
            ]);
       
        } catch (\Exception $e) {           

            return response()->json([
                'success' => false,
                'message' =>  $e->getMessage()
            ], 500);
        }

      
    }

    /**
     * Get statistics about talk proposals.
     */
    public function getStatistics()
    {

        try {
            
            // Total number of proposals
            $totalProposals = TalkProposal::count();

            // Average rating across all proposals
            $averageRating = Review::avg('rating');

            // Number of proposals per tag
            $proposalsPerTag = DB::table('tags')
                ->join('tag_talk_proposal', 'tags.id', '=', 'tag_talk_proposal.tag_id')
                ->select('tags.name', DB::raw('COUNT(tag_talk_proposal.talk_proposal_id) as proposal_count'))
                ->groupBy('tags.name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_proposals' => $totalProposals,
                    'average_rating' => round($averageRating, 2),
                    'proposals_per_tag' => $proposalsPerTag,
                ]
            ]);

        } catch (\Exception $e) {           

            return response()->json([
                'success' => false,
                'message' =>  $e->getMessage()
            ], 500);
        }

       
    }
}
