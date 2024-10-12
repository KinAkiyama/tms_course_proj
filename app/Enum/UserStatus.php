<?php

namespace App\Enum;

enum UserStatus: int
{
    case Active = 1;
    case Inactive = 2;
    case Banned = 3;
}
