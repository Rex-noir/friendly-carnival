<?php

namespace App;

enum UserRoles: string
{
    case ADMIN = 'admin';
    case AUTHOR = 'author';
    case USER = 'user';
}
