<?php

namespace App\Http\Controllers;

use App\CL\Services\Message\MessageService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var MessageService
     */
    private $message;

    /**
     * HomeController constructor.
     *
     * @param MessageService $message
     */
    public function __construct(MessageService $message)
    {
        $this->message = $message;
    }

    public function index()
    {
        $messages = $this->message->all();

        return view('app', compact('messages'));
    }
}
