<?php

namespace App;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case BANNED = 'banned';
}
