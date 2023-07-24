<?php
namespace App\Enums;
use App\Traits\WithLookups;

enum LogEntryClassEnum:string
{
    use WithLookups;

    case ERROR = 'error';
    case WARNING = 'warning';
    case INFO = 'info';
    case SUCCESS = 'success';
}
