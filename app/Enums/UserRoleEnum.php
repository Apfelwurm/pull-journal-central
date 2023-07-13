<?php
namespace App\Enums;
use App\Traits\WithLookups;

enum UserRoleEnum:string
{
    use WithLookups;

    case ADMIN = 'admin';
    case VIEWER = 'viewer';
    case GUEST = 'guest';
}