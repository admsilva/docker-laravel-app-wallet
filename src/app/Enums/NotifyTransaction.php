<?php

namespace App\Enums;

enum NotifyTransaction: string
{
    case SUCCESS = 'success';
    case FAILURE = 'failure';
}
