@extends('layouts.app')

@section('title', 'Sales Highlight')

@section('content')
<div class="main-content">
    <h1 style="font-size: 28px; font-weight: bold;">Sales Highlight Report</h1>

    <div style="margin-top: 30px; background-color: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <!-- Filter Form -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            <form method="GET" style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                <label for="month">Month:</label>
                <select name="month" id="month" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #ccc;">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>

                <label for="year">Year:</label>
                <select name="year" id="year" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #ccc;">
                    @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>

                <button type="submit" style="background-color: #7c1c1c; color: white; border: none; padding: 8px 14px; border-radius: 8px;">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </form>

            <div style="margin-top: 10px;">
                <button onclick="window.print()" style="margin-right: 10px; background-color: #7c1c1c; color: white; border: none; padding: 8px 14px; border-radius: 8px;">
                    <i class="fas fa-print"></i> Print
                </button>
                <button style="background-color: #7c1c1c; color: white; border: none; padding: 8px 14px; border-radius: 8px;">
                    <i class="fas fa-share"></i> Share
                </button>
            </div>
        </div>

        <!-- Chart -->
        <div style="margin-top: 30px;">
            <canvas id="highlightChart" width="400" height="200"></canvas>
        </div>

        <!-- Highlight Table -->
        <table style="width: 100%; border-collapse: collapse; font-size: 14px; margin-top: 30px;">
            <thead>
                <tr style="background-color: #7c1c1c; color: white;">
                    <th style="padding: 12px 15px; text-align: left;">Top Product</th>
                    <th style="padding: 12px 15px; text-align: left;">Top Service</th>
                    <th style="padding: 12px 15px; text-align: left;">Top Order Type</th>
                    <th style="padding: 12px 15px; text-align: left;">Top Buy Method</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px 15px;">{{ $topProduct['product_name'] ?? '-' }} ({{ $topProduct['total'] ?? 0 }})</td>
                    <td style="padding: 12px 15px;">{{ $topService['product_name'] ?? '-' }} ({{ $topService['total'] ?? 0 }})</td>
                    <td style="padding: 12px 15px;">{{ ucfirst($topOrderType->order_type ?? '-') }} ({{ $topOrderType->total ?? 0 }})</td>
                    <td style="padding: 12px 15px;">{{ ucfirst($topBuyMethod->buy_method ?? '-') }} ({{ $topBuyMethod->total ?? 0 }})</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('highlightChart').getContext('2d');
    const highlightChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($productNames) !!},
            datasets: [{
                label: 'Total Sold',
                data: {!! json_encode($quantities) !!},
                backgroundColor: 'rgba(124, 28, 28, 0.2)',
                borderColor: '#7c1c1c',
                borderWidth: 2,
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection
