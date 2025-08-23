<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'ticket_id', 'content'];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Ticket(){
        return $this->belongsTo(Ticket::class);
    }
}
