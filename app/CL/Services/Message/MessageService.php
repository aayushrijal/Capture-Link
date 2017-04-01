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

    /**
     * Gets all the messages
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->message->all();
    }

    /**
     * Finds specific message
     *
     * @param $id
     *
     * @return object
     */
    public function find($id)
    {
        return $this->message->find($id);
    }
}