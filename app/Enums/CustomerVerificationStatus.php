<?php

namespace App\Enums;

enum CustomerVerificationStatus: int
{
    case NOT_VERIFIED = 0;
    case VERIFIED = 1;
    case REJECTED = 2;
}