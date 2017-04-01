<?php

namespace App\CL\Services\API;

use App\CL\Models\Message;
use App\CL\Models\Notification;
use GuzzleHttp\Client as Http;

class ApiImportingService
{
    /**
     * @var Http
     */
    private $http;

    /**
     * ApiImportingService constructor.
     *
     * @param Http $http
     */
    public function __construct(
        Http $http
    ) {
        $this->http = $http;
    }

    public function run()
    {
        $data = $this->fetchUrl();
        $this->dbInsertion($data);
    }

    public function fetchUrl()
    {
        $url      = $this->getUrlApi();
        $response = $this->http->get($url);
        $content  = $response->getBody()->getContents();

        return json_decode($content)->items;
    }

    protected function getUrlApi()
    {
        $room_id = "3722278";
        $token   = "lexG6bpFOdDqGmL9PeIP8V2VTEQKp9Xp0yapvwBa";
        $url     = sprintf(
            "https://api.hipchat.com/v2/room/%s/history?auth_token=%s",
            $room_id,
            $token
        );

        return $url;
    }

    /**
     * @param $data
     */
    protected function dbInsertion($data)
    {
        echo "=========== Beginning Import ===========".PHP_EOL;
        foreach ($data as $row) {
            if ($row->type == 'message') {
                $this->findOrCreateMessage($row);
            } else {
                $message = Message::where('message_id', $row->attach_to)->first();
                $this->findOrCreateNotification($message, $row);
            }
        }
        echo "=========== Finishing Import ===========".PHP_EOL;
    }

    /**
     * @param $row
     *
     * @return static
     */
    protected function findOrCreateMessage($row)
    {
        $message = Message::where('message_id', $row->id)
                          ->first();

        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $row->message, $match);

        if (!empty($match[0])) {
            if (empty($message)) {
                $message = Message::create(
                    [
                        'message_id'     => $row->id,
                        'type'           => $row->type,
                        'message'        => $match[0][0],
                        'sender'         => $row->from->name,
                        'date'           => $row->date,
                        'mentioned_name' => empty($row->mentions) ? '' : $row->mentions[0]->name,
                    ]
                );
            }
        }

        return $message;
    }

    protected function findOrCreateNotification($message, $row)
    {
        $notification = Notification::where('message_id', $message->id)
                                    ->first();

        if (empty($notification)) {
            $notification = Notification::create(
                [
                    'notification_id' => $row->id,
                    'message_id'      => $message->id,
                    'type'            => $row->type,
                    'date'            => $row->date,
                    'card'            => json_decode($row->card)->icon->url,
                    'message'         => json_decode($row->card)->description,
                ]
            );
        }

        return $notification;
    }
}