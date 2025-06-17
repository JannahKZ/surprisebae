@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <h2 class="mb-4">📊 Monthly Report Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <label>Select Month:</label>
            <input type="month" id="month" class="form-control" value="{{ now()->format('Y-m') }}">
        </div>
        <div class="col-md-5">
            <label>Select Report Type:</label>
            <select id="reportType" class="form-control">
                <option value="all">All Reports</option>
                <option value="order_types">Order Type</option>
                <option value="sales">Sales</option>
                <option value="top">Top Products & Services</option>
            </select>
        </div>
        <div class="col-md-2 align-self-end">
            <button class="btn btn-primary w-100" onclick="fetchReport()">Generate</button>
        </div>
    </div>

    <div id="report" class="row">
        <div id="section-order-types" class="col-md-12 mb-4" style="display: none;">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">Order Types</div>
                <div class="card-body">
                    <ul id="order-types" class="list-group"></ul>
                </div>
            </div>
        </div>

        <div id="section-sales" class="col-md-12 mb-4" style="display: none;">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">Sales Summary</div>
                <div class="card-body">
                    <ul id="sales-summary" class="list-group"></ul>
                </div>
            </div>
        </div>

        <div id="section-top" class="col-md-12 mb-4" style="display: none;">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">Top Products & Services</div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <h5>Top Products</h5>
                        <ul id="top-products" class="list-group"></ul>
                    </div>
                    <div class="col-md-6">
                        <h5>Top Services</h5>
                        <ul id="top-services" class="list-group"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function fetchReport() {
        const month = document.getElementById('month').value;
        const type = document.getElementById('reportType').value;

        fetch(`/report/data/${month}?type=${type}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('section-order-types').style.display = 'none';
                document.getElementById('section-sales').style.display = 'none';
                document.getElementById('section-top').style.display = 'none';

                if (data.order_types) {
                    document.getElementById('section-order-types').style.display = 'block';
                    let otHtml = '';
                    data.order_types.forEach(item => {
                        otHtml += `<li class="list-group-item">${item.order_type}: ${item.count}</li>`;
                    });
                    document.getElementById('order-types').innerHTML = otHtml;
                }

                if (data.sales) {
                    document.getElementById('section-sales').style.display = 'block';
                    let s = data.sales;
                    let ssHtml = `
                        <li class="list-group-item">Total Sales: MYR ${s.total_sales}</li>
                        <li class="list-group-item">Transactions: ${s.transactions}</li>
                        <li class="list-group-item">Average Order: MYR ${s.avg_order_value}</li>
                        <li class="list-group-item">Top Day: ${s.highest_sales_day?.day ?? '-'} (MYR ${s.highest_sales_day?.total ?? '-'})</li>
                    `;
                    document.getElementById('sales-summary').innerHTML = ssHtml;
                }

                if (data.top_products || data.top_services) {
                    document.getElementById('section-top').style.display = 'block';

                    let tpHtml = '';
                    data.top_products?.forEach(p => {
                        tpHtml += `<li class="list-group-item">${p.name} - Sold: ${p.sold}, Revenue: MYR ${p.revenue}</li>`;
                    });
                    document.getElementById('top-products').innerHTML = tpHtml;

                    let tsHtml = '';
                    data.top_services?.forEach(s => {
                        tsHtml += `<li class="list-group-item">${s.name} - Bookings: ${s.bookings}, Revenue: MYR ${s.revenue}</li>`;
                    });
                    document.getElementById('top-services').innerHTML = tsHtml;
                }
            });
    }

    window.onload = fetchReport;
</script>
@endsection
