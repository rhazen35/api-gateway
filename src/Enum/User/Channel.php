<?php

declare(strict_types=1);

namespace App\Enum\User;

class Channel
{
    const USER_CREATED = 'user_created';
    const USER_UPDATED = 'user_updated';
    const USER_DELETED = 'user_deleted';

    const GET_USER = 'get_user';
    const GET_USER_RESULT = 'get_user_result';
}