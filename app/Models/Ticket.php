<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TicketStatusEnum;
use App\Enums\TicketPriorityEnum;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'status', 'priority'];

    protected $casts = [
        'status' => TicketStatusEnum::class,
        'priority' => TicketPriorityEnum::class,
    ];

    protected $attributes = [
    'status' => TicketStatusEnum::Open,
];

    // Relation to engineer (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class)->orderBy('created_at', 'asc');
    }
}
