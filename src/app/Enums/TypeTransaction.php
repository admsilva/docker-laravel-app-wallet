<?php

namespace App\Enums;

enum TypeTransaction: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';
    case TRANSFER = 'transfer';
}
