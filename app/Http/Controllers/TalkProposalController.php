<?php

namespace App\Http\Controllers;

use App\Models\TalkProposal;
use App\Events\ProposalUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\Tag;

class TalkProposalController extends Controller
{
    public function index(Request $request)
    {

        $query = TalkProposal::query();
        $query->where('speaker_id', Auth::id());
        $search_input = "";        
        if ($request->has('tags') &&  !empty($request->input('tags'))) {
            $search_input =  $request->input('tags');
            $tags = explode(',', $request->input('tags'));
            $query->withTags($tags);
        }

        $talkProposals = $query->get();
            // dD($talkProposals);
        return view('talk_proposals.index', compact('talkProposals','search_input'));
    }



    public function create()
    {
        $tags = Tag::all();
        return view('talk_proposals.create', compact('tags'));
    }

    public function store(Request $request)
    {

        try {

            DB::beginTransaction();
            $input = $request->all();

            $validator = Validator::make($request->all(), [
               
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'file' => 'nullable|mimes:pdf|max:2048',  // Validate file as PDF with max size 2MB,
                'tags' => 'nullable|array', // Expect tags to be an array
                'tags.*' => 'exists:tags,id', // Each tag must exist in the tags table

            ]);
     
            if ($validator->fails()) {
                $request->session()->flash('error', $validator->messages()->all()[0]);
                return back()
                    ->withErrors($validator)
                    ->withInput();


            }
            // Handle the file upload if present
            $filePath = null;
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('proposals', 'public');
            }
          
            // Create a new TalkProposal
            $talkProposal = TalkProposal::create([
                'title' => $input['title'],
                'description' => $input['description'],
                'file_path' => $filePath,
                'speaker_id' => Auth::id(),
            ]);

            if (isset($input['tags'])) {
                $talkProposal->tags()->attach($input['tags']); // Attach tags
            }

            event(new ProposalUpdated($talkProposal, 'added'));
            DB::commit();
            return redirect()->route('talk-proposals.index')->with('success', 'Talk Proposal Created Successfully');
        } catch (\Exception $e) {           
            DB::rollback();           
            return redirect()->back()->with('error',  $e->getMessage());           
           
        }
    }

    public function show(TalkProposal $talkProposal)
    {
      
        return view('talk_proposals.show', compact('talkProposal'));
    }

    public function edit(TalkProposal $talkProposal)
    {
        $tags = Tag::all();
        return view('talk_proposals.edit', compact('talkProposal','tags'));
    }

    public function update(Request $request, TalkProposal $talkProposal)
    {

        try {
          
            DB::beginTransaction();
            $input = $request->all();

            $validator = Validator::make($request->all(), [
               
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'file' => 'nullable|mimes:pdf|max:2048',  // Validate file as PDF with max size 2MB,
                'tags' => 'nullable|array',
                'tags.*' => 'exists:tags,id',

            ]);
     
            if ($validator->fails()) {
                $request->session()->flash('error', $validator->messages()->all()[0]);
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Handle file upload if a new file is uploaded
            if ($request->hasFile('file')) {
                // Delete the old file if it exists
                if ($talkProposal->file_path) {
                    Storage::disk('public')->delete($talkProposal->file_path);
                }

                // Store the new file
                $talkProposal->file_path = $request->file('file')->store('proposals', 'public');
            }

            // Update the TalkProposal with validated data
            $talkProposal->update([
                'title' => $input['title'],
                'description' => $input['description'],
                'file_path' => $talkProposal->file_path,
            ]);

            if (isset($input['tags'])) {
                $talkProposal->tags()->sync($input['tags']); // Sync tags
            } else {
                $talkProposal->tags()->sync([]); // Sync tags
            }
            event(new ProposalUpdated($talkProposal, 'updated'));
            DB::commit();
            return redirect()->route('talk-proposals.index')->with('success', 'Talk Proposal Updated Successfully');

        } catch (\Exception $e) {           
            DB::rollback();           
            return redirect()->back()->with('error',  $e->getMessage());           
           
        }
       
      
    }

    public function destroy(TalkProposal $talkProposal)
    {
      
        try {
            
            $talkProposal->delete();

            return redirect()->route('talk-proposals.index')->with('success', 'Talk Proposal Deleted Successfully');
            
        } catch (\Exception $e) {           
            DB::rollback();           
            return redirect()->back()->with('error',  $e->getMessage());           
           
        }

      
    }
}
