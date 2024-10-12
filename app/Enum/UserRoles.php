<?php

namespace App\Enum;

enum UserRoles: string
{
    case User = 'ROLE_USER';

    case Admin = 'ROLE_ADMIN';
}
