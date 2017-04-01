<?php

namespace App\CL\Repositories\Notification;

use App\CL\Repositories\Repository;

class NotificationRepository extends Repository
{
    /**
     * @return string
     */
    function getModel()
    {
        return 'App\CL\Models\Notification';
    }
}
