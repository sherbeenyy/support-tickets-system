<?php
// app/DTOs/Ticket/UpdateTicketDTO.php
namespace App\DTOs\Ticket;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UpdateTicketDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $priority,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            title: $request->get('title'),
            description: $request->get('description'),
            priority: $request->get('priority'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: Arr::get($data, 'title'),
            description: Arr::get($data, 'description'),
            priority: Arr::get($data, 'priority'),
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
        ];
    }

    public static function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ];
    }
}
