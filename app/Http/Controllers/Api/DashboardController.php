<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use ApiResponse;

    /** Get All Notifictaions */
    public function getNotifications() {
        $user = Auth::user();
        return $this->ResponseSuccess($user->unreadNotifications);
    }

     /** Read All Notifictaions */
    public function marAsReadAll() {
        $user = Auth::user();
        $user->unreadNotifications()->update(['read_at' => now()]);
        return $this->ResponseSuccess($user->unreadNotifications);
    }
}
