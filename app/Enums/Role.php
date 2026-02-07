<?php

namespace App\Enums;

enum Role:string
{
    case PLATFORM_SUPER_ADMIN = 'platform_super_admin';
    case PLATFORM_ADMIN = 'platform_admin';
    case PLATFORM_EMPLOYEE = 'platform_employee';

    case OWNER = 'owner';
    case ADMIN = 'admin';
    case ACCOUNTANT = 'accountant';
    case VIEWER = 'viewer';
function label(): string{
    return match ($this) {
        self::PLATFORM_ADMIN => "Platform Admin",
        self::PLATFORM_EMPLOYEE => "Platform Employee",
        self::PLATFORM_SUPER_ADMIN => "Platform Super Admin",
        self::OWNER => "Owner",
        self::ADMIN => "Admin",
        self::ACCOUNTANT => "Accountant",
        self::VIEWER => "Viewer",
    };
}

}
