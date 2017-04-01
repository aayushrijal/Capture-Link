<?php

namespace App\CL\Services\Message;

use App\CL\Repositories\Message\MessageRepository;

class MessageService
{
    /**
     * @var MessageRepository
     */
    private $message;

    /**
     * MessageService constructor.
     *
     * @param MessageRepository $message
     */
    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }

    public function all()
    {
        return $this->message->all();
    }

    public function find($id)
    {
        return $this->message->find($id);
    }
}