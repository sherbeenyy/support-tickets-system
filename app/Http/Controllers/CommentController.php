<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function index(Ticket $ticket)
    {
        $comments = $ticket->comments()->with('user')->latest()->get();
           
        return view('engineer.dashboard', compact('ticket'));
    }


    public function store(CommentRequest $request)
    {
        try {
            
            $validated = $request->validated();

            // Ensure ticket exists (extra safety, since CommentRequest already checks)
            $ticket = Ticket::findOrFail($validated['ticket_id']);

            // Create the comment
            Comment::create([
                'ticket_id' => $ticket->id,
                'user_id'   => auth("web")->id(),
                'content'   => $validated['content'],
            ]);

            return redirect()
                ->route('comments.index', $ticket->id)
                ->with('success', 'Comment added successfully!');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something went wrong while adding the comment.');
        }
    }



    public function edit(Comment $comment)
    {
        if ($comment->user_id !== auth("web")->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('comments.edit', compact('comment'));
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        if ($comment->user_id !== auth("web")->id()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->update($request->validated());

        return redirect()->route('comments.index', $comment->ticket_id)
                         ->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth("web")->id()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
