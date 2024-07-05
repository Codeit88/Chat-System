<?php

namespace App\Events;

use App\Models\User;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log; // Import the Log facade

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param Message $message
     */
    public function __construct(User $user, Message $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new Channel('chat');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                // Add any other user attributes you need
            ],
            'message' => [
                'id' => $this->message->id,
                'content' => $this->message->message,
                // Add any other message attributes you need
            ],
        ];
    }

    /**
     * Handle broadcast success event.
     *
     * @return void
     */
    public function broadcastSent()
    {
        Log::info('MessageSent event broadcasted successfully.');
    }

    /**
     * Handle broadcast error event.
     *
     * @param \Exception $exception
     * @return void
     */
    public function broadcastFailed(\Exception $exception)
    {
        Log::error('MessageSent event failed to broadcast.', ['exception' => $exception]);
    }
}
