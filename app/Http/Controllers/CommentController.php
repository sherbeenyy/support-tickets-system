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
           
        return view('engineer.dashboard', compact('tickets'));
    }


    public function store(CommentRequest $request)
    {   
        try {
            
            $validated = $request->validated();

            $ticket = Ticket::findOrFail($validated['ticket_id']);

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
}
