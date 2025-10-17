<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class AdminCheckoutController extends Controller
{
    public function orders() {
        $orders = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.orders.orders', compact('orders'));
    }

    public function orderDetail(Order $order) {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.detail', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order) {
        $request->validate([
            'payment_status' => 'required|in:pending,success,failed',
        ]);

        $order->update([
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->back()->with('success', 'Status order berhasil diupdate!');
    }

    public function updateItemStatus(Request $request, OrderItem $item) {
        $request->validate([
            'status' => 'required|in:pending,processed,shipped,completed,canceled',
        ]);

        $item->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status item berhasil diupdate!');
    }
}
