<?php

namespace App\Modules\Task\Enums;

enum TaskStatus: string
{
    case Open = 'open';
    case Done = 'done';

    public function label(): string
    {
        return match($this) {
            self::Open => 'Aberta',
            self::Done => 'Concluída',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Open => 'bg-yellow-100 text-yellow-800',
            self::Done => 'bg-green-100 text-green-800',
        };
    }
} 