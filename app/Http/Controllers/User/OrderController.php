<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\DecoService;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'order_type' => 'required|in:product,service',
            'shipping_option' => 'required|in:pickup,delivery',
            'payment_method' => 'required|in:card,cash',
            'status' => 'required|in:paid,pending',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'time' => 'required|string',

            // Conditional fields
            'pickup_name' => 'required_if:shipping_option,pickup',
            'pickup_phone' => 'required_if:shipping_option,pickup',
            'delivery_email' => 'required_if:shipping_option,delivery|email',
            'delivery_name' => 'required_if:shipping_option,delivery',
            'delivery_phone' => 'required_if:shipping_option,delivery',
            'delivery_address' => 'required_if:shipping_option,delivery',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 2. Get user and seller ID (assumed passed via token or frontend)
        //$user = auth()->user();
        //$sellerId = $request->seller_id ?? null;

        // 3. Create order
        $order = Order::create([
            'user_id' => $request->user_id,
            //'seller_id' => $sellerId,
            'order_type' => $request->order_type,
            'shipping_option' => $request->shipping_option,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'total_amount' => $request->total_amount,
            'date' => $request->date,
            'time' => $request->time,
            'pickup_name' => $request->pickup_name,
            'pickup_phone' => $request->pickup_phone,
            'delivery_name' => $request->delivery_name,
            'delivery_phone' => $request->delivery_phone,
            'delivery_address' => $request->delivery_address,
            'delivery_email' => $request->delivery_email,
        ]);

        // 4. Save order items
        foreach ($request->items as $item) {
            if ($request->order_type === 'product') {
                $itemModel = Product::find($item['id']);
            } else {
                $itemModel = DecoService::find($item['id']);
            }

            if (!$itemModel) continue;

            OrderItem::create([
                'order_id' => $order->id,
                'item_type' => $request->order_type,
                'item_id' => $item['id'],
                'item_name' => $itemModel->name,
                'price' => $itemModel->price,
                'quantity' => $item['quantity'],
            ]);
        }

        // 5. (Optional) Send chat notification or event dispatch
        // e.g., Chat::notifyAdminNewOrder($order);

        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    }

    public function getDeliveryOrdersByEmail($email)
    {

        $orders = Order::with('items')
            ->where('shipping_option', 'delivery')
            ->where('delivery_email', $email)
            ->get();

        return response()->json($orders);
    }

}
