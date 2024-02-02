<?php

namespace App\Enums;

enum JobStatus: int
{
    case PENDING = 0;
    case COMPLETED = 1;
    case FAILED = 2;

    public static function allType()
    : array
    {
        return array_column(JobStatus::cases(), 'value');
    }
}