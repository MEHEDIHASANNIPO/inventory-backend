<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Salary;
use App\Models\Expense;
use App\Models\Product;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Models\User as Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    use ApiResponse;

    /** Dashboard Info */
    public function dashboard() {
        Gate::authorize('access-dashboard');

        $data = [];

        // Dashboard Count
        $data['profit'] = Order::sum('total');
        $data['products'] = Product::count();
        $data['sales'] = Order::count();
        $data['customers'] = Customer::customer()->count();

        // Chart Data
        $data['stats'] = [];

        for ($i= 1; $i <= 12; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1, date('Y')));

            $expense = Expense::whereMonth('created_at', $i)->sum('amount');
            $sales = Order::whereMonth('created_at', $i)->count();
            $salary = Salary::whereMonth('created_at', $i)->sum('amount');
            $profit = Order::whereMonth('created_at', $i)->sum('total');

            array_push($data['stats'], [
                'month' => $month,
                'expense' => $expense,
                'sales' => $sales,
                'profit' => $profit,
                'salary' => $salary,
            ]);
        }

        return $this->ResponseSuccess($data);
    }

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
