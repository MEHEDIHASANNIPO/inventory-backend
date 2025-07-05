<?php
namespace App\Enums;

enum PasswordUpdateStatus: int {
    case UPDATED               = 1;
    case SAME_AS_OLD           = 2;
    case OLD_PASSWORD_MISMATCH = 3;
}
