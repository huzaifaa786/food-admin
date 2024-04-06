<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PLACED = 'PLACED';
    case ACCEPTED  = 'ACCEPTED';
    case ON_THE_WAY  = 'ON_THE_WAY';
    case REJECTED = 'REJECTED';
}
