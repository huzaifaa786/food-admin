<?php

namespace App\Enums;

enum RestrauntStatus: int
{
    case CLOSED = 0;
    case OPENED  = 1;
    case BUSY = 2;
}
