<?php

namespace App\Http\Controllers;

use App\CL\Services\API\ApiImportingService;
use App\CL\Services\Message\MessageService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var MessageService
     */
    private $message;
    /**
     * @var ApiImportingService
     */
    private $api;

    /**
     * HomeController constructor.
     *
     * @param MessageService      $message
     * @param ApiImportingService $api
     */
    public function __construct(MessageService $message, ApiImportingService $api)
    {
        $this->message = $message;
        $this->api = $api;
    }

    /**
     * Stores api data into database and returns to view from DB
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $messages = $this->message->all();

        return view('app', compact('messages'));
    }

    /**
     * Pull api directly so as to reflect real time changes in the chat room
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function api()
    {
        $apis = $this->api->fetchUrl();

        return view('welcome',compact('apis'));
    }
}
