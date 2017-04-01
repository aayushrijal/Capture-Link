<?php

namespace App\Cl\Repositories\Message;

use App\CL\Repositories\Repository;

class MessageRepository extends Repository
{
    /**
     * @return string
     */
    function getModel()
    {
        return 'App\CL\Models\Message';
    }
}