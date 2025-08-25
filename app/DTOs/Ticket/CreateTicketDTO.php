<?php
// app/DTOs/Ticket/CreateTicketDTO.php
namespace App\DTOs\Ticket;

use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CreateTicketDTO extends Base
{
    public function __construct(
        public readonly int $user_id,
        public readonly string $description,
        public readonly string $priority,
        public readonly ?string $title = null,
    ) {}

    public static function fromRequest(Request $request, int $userId): self
    {
        return new self(
            user_id: $userId,
            title: $request->get('title'),
            description: $request->get('description'),
            priority: $request->get('priority'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: Arr::get($data, 'user_id'),
            title: Arr::get($data, 'title'),
            description: Arr::get($data, 'description'),
            priority: Arr::get($data, 'priority'),
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
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
