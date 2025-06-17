@extends('layouts.app')

@section('content')
<div class="main-content">
    <h1 style="font-size: 28px; font-weight: bold;">Dashboard</h1>

    <div style="display: flex; flex-wrap: wrap; margin-top: 30px; gap: 30px; align-items: flex-start;">

        <!-- Left: Order Table -->
        <div style="flex: 1; min-width: 60%;">
            <div style="background-color: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 20px;">Order</h2>
                    <div>
                        <button style="margin-right: 10px; background-color: #7c1c1c; color: white; border: none; padding: 8px 14px; border-radius: 8px;"><i class="fas fa-print"></i> Print</button>
                        <button style="background-color: #7c1c1c; color: white; border: none; padding: 8px 14px; border-radius: 8px;"><i class="fas fa-share"></i> Share</button>
                    </div>
                </div>

                <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                    <thead>
                        <tr style="background-color: #7c1c1c; color: white;">
                            <th style="padding: 12px 15px; text-align: left;">Type</th>
                            <th style="padding: 12px 15px; text-align: left;">Date</th>
                            <th style="padding: 12px 15px; text-align: left;">Order Summary</th>
                            <th style="padding: 12px 15px; text-align: left;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr style="border-bottom: 1px solid #eee;">
                            <!-- Type -->
                            <td style="padding: 12px 15px;">
                                <strong>{{ ucfirst($order->type) }}</strong><br>
                                <small style="color: gray;">{{ ucfirst($order->delivery_type) }}</small>
                            </td>

                            <!-- Date -->
                            <td style="padding: 12px 15px;">
                                {{ \Carbon\Carbon::parse($order->order_date)->isToday() ? 'Today' : (\Carbon\Carbon::parse($order->order_date)->isYesterday() ? 'Yesterday' : \Carbon\Carbon::parse($order->order_date)->format('d M')) }}
                                <br>
                                <small style="color: gray;">
                                    {{ \Carbon\Carbon::parse($order->order_date)->diffForHumans() }}
                                </small>
                            </td>

                            <!-- Order Summary -->
                            <td style="padding: 12px 15px;">
                                <a href="{{ route('orders.show', $order->id) }}" style="color: #7c1c1c; text-decoration: none;">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>

                            <!-- Status -->
                            <td style="padding: 12px 15px;">
                                @if ($order->status === 'completed')
                                    <span style="color: #10b981;"><i class="fas fa-check-circle"></i> Done</span>
                                @elseif ($order->status === 'pending')
                                    <span style="color: #f59e0b;"><i class="fas fa-clock"></i> Pending</span>
                                @else
                                    <span style="color: #6b7280;">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px;">No orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Statistics Panel -->
        <div style="width: 280px; flex-shrink: 0;">
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <!-- Total Orders Today -->
                <div style="background: #ffffff; padding: 20px; border-radius: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 15px;">
                    <div style="background-color: #a83268; color: white; border-radius: 50%; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 500;">Total Orders Today</div>
                        <div style="font-size: 22px; font-weight: bold;">{{ $ordersToday }}</div>
                    </div>
                </div>

                <!-- Low Stock -->
                <div style="background: #ffffff; padding: 20px; border-radius: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 15px;">
                    <div style="background-color: #f59e0b; color: white; border-radius: 50%; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 500;">Low Stock</div>
                        <div style="font-size: 22px; font-weight: bold;">{{ $lowStock }}</div>
                    </div>
                </div>

                <!-- Out of Stock -->
                <div style="background: #ffffff; padding: 20px; border-radius: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 15px;">
                    <div style="background-color: #dc2626; color: white; border-radius: 50%; width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 500;">Out of Stock</div>
                        <div style="font-size: 22px; font-weight: bold;">{{ $outOfStock }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
