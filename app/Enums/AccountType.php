<?php

namespace App\Enums;

enum AccountType: string
{
    case EMAIL = 'EMAIL';
    case OTP  = 'OTP';
    case APPLE  = 'APPLE';
    case GOOGLE = 'GOOGLE';
}
