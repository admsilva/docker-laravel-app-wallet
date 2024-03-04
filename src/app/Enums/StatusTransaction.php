<?php

namespace App\Enums;

enum StatusTransaction: string
{
    case SUCCESS = 'success';
    case FAILURE = 'failure';
}
