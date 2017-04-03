<?php

namespace App\CL\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * @package App\CL\Models
 */
class Notification extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['notification_id', 'message_id', 'type', 'date', 'card', 'message'];
}
