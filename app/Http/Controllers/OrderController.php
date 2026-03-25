<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class OrderController extends BaseController
{
    public function index(): View
    {
        $orders = Order::orderBy('created_at', 'desc')->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', compact('order'));
    }
}
