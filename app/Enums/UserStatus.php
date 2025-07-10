<?php

namespace App\Enums;

enum UserStatus: int
{
    case Active = 1;
    case Inactive = 2;
    case Blocked = 3;
    case Suspended = 4;
    case Warning = 5;
}
