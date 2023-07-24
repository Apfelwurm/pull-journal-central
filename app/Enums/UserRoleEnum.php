<?php
namespace App\Enums;
use App\Traits\WithLookups;

enum UserRoleEnum:string
{
    use WithLookups;

    case SUPERADMIN = 'superadmin';
    case DEVICEADMIN = 'deviceadmin';
    case VIEWER = 'viewer';
    case GUEST = 'guest';
}
