<?php

namespace App\Enums;

enum LogAction: string
{

    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case VIEW = 'view';
    case EXPORT = 'export';

    function label():string
    {
        return match ($this) {
            self::CREATE  => "Create",
            self::UPDATE => "Update",
            self::DELETE => "Delete",
            self::VIEW => "View",
            self::EXPORT => "Export",
        };
    }

}
