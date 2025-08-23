<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function create(array $data)
    {
        return Comment::create($data);
    }

    public function findById($id)
    {
        return Comment::findOrFail($id);
    }

    public function getByTicket($ticketId)
    {
        return Comment::where('ticket_id', $ticketId)
                      ->with('user')
                      ->latest()
                      ->get();
    }

    public function update(Comment $comment, array $data)
    {
        $comment->update($data);
        return $comment;
    }

    public function delete(Comment $comment)
    {
        return $comment->delete();
    }
}
