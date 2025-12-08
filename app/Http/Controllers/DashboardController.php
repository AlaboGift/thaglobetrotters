<?php

namespace App\Http\Controllers;

use App\Enums\DeliveryStatus;
use App\Mail\SendDeliveryStatusMail;
use App\Models\AdminNotification;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Utils\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Toastr;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $hasStats = true;
        $active = 'dashboard';

        $users = User::selectRaw("
            COUNT(id) as all_users,
            SUM(CASE WHEN last_login IS NOT NULL THEN 1 ELSE 0 END) as online_users
        ")->first();
        
        return view('admin.index', compact('title', 'users'));
    }

    public function getWeeklySales()
    {
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY);
        $startOfWeek = $endOfWeek->copy()->subDays(6);

        $salesArray = [];

        for ($date = $startOfWeek->copy(); $date <= $endOfWeek; $date->addDay()) {
            $salesOfTheDay = Transaction::whereDate('created_at', $date)
                ->where('status', 'SUCCESSFUL')
                ->sum('amount');

            $salesArray[] = $salesOfTheDay;
        }

        return $salesArray;
    }

    public function getMonthlySales()
    {
        $salesArray = [];
    
        for ($month = 1; $month <= 12; $month++) {
            $salesOfTheMonth = Transaction::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', $month)
                ->where('status', 'SUCCESSFUL')
                ->sum('amount');
    
            $salesArray[] = $salesOfTheMonth;
        }
    
        return $salesArray;
    }

    public function notifications()
    {
        $title = 'Notifications';
        $adminNotifications = AdminNotification::where('notifiable_id', 0)->whereNull('read_at')->latest()->paginate(20);
        return view('admin.notifications', compact('title', 'adminNotifications'));
    }

    public function readNotifications($id = null)
    {
        $id ? AdminNotification::where('id', $id)->update(['read_at' => now()]) : 
            AdminNotification::where('notifiable_id', 0)->update(['read_at' => now()]);

        Toastr::error('Marked as read');
        return redirect()->back();
    }

    public function customers()
    {
        $title = 'Customers';
        $customers = User::customers()->latest()->paginate(20);
        return view('admin.customers', compact('title', 'customers'));
    }

    public function orders()
    {
        $title = 'Orders';
        $hasStats2 = true;

        $users = User::selectRaw("
            COUNT(id) as all_users,
            SUM(CASE WHEN last_login IS NOT NULL THEN 1 ELSE 0 END) as online_users
        ")->first();

        $products = Product::selectRaw("
            COUNT(id) as all_products,
            SUM(cost_price) as total_stock_cost_price,
            SUM(selling_price) as total_stock_sell_price")->first();

        $orders = Transaction::selectRaw("
            COUNT(id) as all_transactions,
            SUM(amount) as total_transactions,
            SUM(CASE WHEN status = 'SUCCESSFUL' THEN 1 ELSE 0 END) as successful_transactions,
            SUM(CASE WHEN status = 'FAILED' THEN 1 ELSE 0 END) as failed_transactions,
            SUM(CASE WHEN status = 'PENDING' THEN 1 ELSE 0 END) as pending_transactions,
            SUM(CASE WHEN status = 'SUCCESSFUL' THEN amount ELSE 0 END) as total_successful_transactions,
            SUM(CASE WHEN status = 'FAILED' THEN amount ELSE 0 END) as total_failed_transactions,
            SUM(CASE WHEN status = 'PENDING' THEN amount ELSE 0 END) as total_pending_transactions
        ")->first();

        $salesArray = $this->getWeeklySales();
        $monthlySalesArray = $this->getMonthlySales();

        $sales = Transaction::latest()->paginate(20);
        
        return view('admin.orders', compact('title', 'products', 'users','orders', 'hasStats2', 'salesArray', 'sales', 'monthlySalesArray'));
    }

    public function order($ref)
    {
        $title = 'Order Details';
        $order = Transaction::firstWhere('reference', $ref);
        $deliveryStatuses = DeliveryStatus::getValues();
        return view('admin.order', compact('title','order', 'deliveryStatuses'));
    }

    public function updateOrderDeliveryStatus(Request $request, $id)
    {
        $order = Transaction::find($id);

        if(!$order){
            Toastr::error('Invalid Order Selected');
            return redirect()->back();
        }


        if(!in_array($request->delivery_status, DeliveryStatus::getValues())){
            Toastr::error('Invalid Status Selected');
            return redirect()->back();
        }

        $order->update(['delivery_status' => $request->delivery_status]);

        $action = strtolower($order->delivery_status);

        $order->user->notif([
            'subject' => "Order with Ref: {$order->reference} has been {$action}",
            'body' => "Order with Ref: {$order->reference} has been {$action}"
        ]);

        Utils::adminNotification([
            'subject' => "Order with Ref: {$order->reference} has been {$action}",
            'body' => "Order with Ref: {$order->reference} has been {$action}"
        ]);

        Mail::to($order->user)->later(now()->addSeconds(3), new SendDeliveryStatusMail($order->user, $order, $action));
        
        Toastr::error('Delivery Status Updated Successfully');
        return redirect()->back();
    }
}
