<?php
namespace App\Enums;

enum TicketPriorityEnum: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
}
