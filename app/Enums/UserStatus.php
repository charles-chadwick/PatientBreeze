<?php

namespace App\Enums;

enum UserStatus : string
{
    case Active = "Active";
    case Inactive = "Inactive";
    case Banned = "Banned";
    case ReadOnly = "Read Only";
}
