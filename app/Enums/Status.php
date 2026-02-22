<?php

namespace App\Enums;

enum Status: string
{
    case Pending = 'pending';
    case Active = 'active';
    case InProgress = 'in_progress';
    case Completed = 'completed';
}
