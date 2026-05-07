<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class SmsSendingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $to;
    public ?string $templateKey;
    public array $templateData;
    public ?Model $sendable;
    public ?int $userId;

    public function __construct(
        string $to,
        string $templateKey,
        array $templateData,
        ?Model $sendable = null,
        ?int $userId = null
    ) {
        $this->to = $to;
        $this->templateKey = $templateKey;
        $this->templateData = $templateData;
        $this->sendable = $sendable;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
