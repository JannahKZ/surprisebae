@extends('layouts.app')

@section('title', 'Inventory Report')

@section('content')
<div class="main-content">
    <h1 style="font-size: 28px; font-weight: bold;">Inventory Report</h1>

    <div style="margin-top: 30px; background-color: white; padding: 25px; border-radius: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 20px;">Product Stock Overview</h2>
            <div>
                <button onclick="window.print()" style="margin-right: 10px; background-color: #7c1c1c; color: white; border: none; padding: 8px 14px; border-radius: 8px;"><i class="fas fa-print"></i> Print</button>
                <button style="background-color: #7c1c1c; color: white; border: none; padding: 8px 14px; border-radius: 8px;"><i class="fas fa-share"></i> Share</button>
            </div>
        </div>

        <div style="display: flex; gap: 30px; flex-wrap: wrap;">
            <!-- Chart on the Left -->
            <div style="flex: 1 1 40%;">
                <canvas id="stockChart" style="max-width: 100%; height: auto;"></canvas>
            </div>

            <!-- Table on the Right -->
            <div style="flex: 1 1 55%; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 14px; margin-top: 10px;">
                    <thead>
                        <tr style="background-color: #7c1c1c; color: white;">
                            <th style="padding: 12px 15px; text-align: left;">Product Name</th>
                            <th style="padding: 12px 15px; text-align: left;">Category</th>
                            <th style="padding: 12px 15px; text-align: left;">Stock</th>
                            <th style="padding: 12px 15px; text-align: left;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products->sortBy(fn($p) => $p->category->name ?? 'Uncategorized') as $product)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px 15px;">{{ $product->name }}</td>
                            <td style="padding: 12px 15px;">{{ $product->category->name ?? 'Uncategorized' }}</td>
                            <td style="padding: 12px 15px;">{{ $product->stock }}</td>
                            <td style="padding: 12px 15px;">
                                @if ($product->stock == 0)
                                    <span style="color: #dc2626;">Out of Stock</span>
                                @elseif ($product->stock < 10)
                                    <span style="color: #f59e0b;">Low Stock</span>
                                @else
                                    <span style="color: #3b82f6;">Good</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('stockChart').getContext('2d');
    const inventoryChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Good Stock', 'Low Stock', 'Out of Stock'],
            datasets: [{
                data: [
                    {{ $products->where('stock', '>=', 10)->count() }},
                    {{ $products->where('stock', '<', 10)->where('stock', '>', 0)->count() }},
                    {{ $products->where('stock', 0)->count() }}
                ],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(245, 158, 11, 0.7)',
                    'rgba(220, 38, 38, 0.7)'
                ],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection
