<?php
namespace App\Enums;

enum UserRole: int {
    case ADMIN    = 1;
    case MANAGER  = 2;
    case EMPLOYEE = 3;
    case SUPPLIER = 4;
    case CUSTOMER = 5;
}
