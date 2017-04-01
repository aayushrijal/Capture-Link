<?php

namespace App\CL\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 * @package App\CL\Models
 */
class Message extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['message_id', 'type', 'message', 'sender', 'date', 'mentioned_name'];
}
