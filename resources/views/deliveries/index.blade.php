{{-- resources/views/deliveries/index.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    /* ====== COLOUR & FONT (unchanged) ====== */
    body          { background-color:#ffe6ea; font-family:'Poppins',sans-serif; }
    .category-container{ padding:30px; }

    /* ====== TOOLBAR ====== */
    .toolbar      { display:flex; justify-content:space-between; align-items:center;
                    margin-bottom:20px; flex-wrap:wrap; gap:12px; }
    .toolbar h1   { font-weight:700; color:#000; font-size:32px; }
    .header-actions{ display:flex; align-items:center; gap:20px; }
    .top-add-btn  { text-decoration:none; text-align:center; background:#800000; color:#fff;
                    font-weight:500; font-size:14px; padding:8px 16px; border-radius:8px;
                    display:flex; align-items:center; gap:8px; transition:background-color .3s; }
    .top-add-btn:hover{ background:#a00000; }

    /* ====== SEARCH BAR ====== */
    .search-bar   { display:flex; align-items:center; border:1px solid #ccc;
                    border-radius:8px; overflow:hidden; }
    .search-bar input{ width:250px; padding:8px 12px; border:none; outline:none; }
    .search-bar button{ background:#800000; border:none; padding:8px 16px;
                        cursor:pointer; color:#fff; transition:.3s; display:flex; justify-content:center; }
    .search-bar button:hover{ background:#a00000; }

    /* ====== TABLE CARD ====== */
    .table-section{ display:flex; gap:30px; flex-wrap:wrap; }
    .table-card   { background:#ffb6c1; border-radius:16px; padding:20px; flex:1; min-width:950px;
                    box-shadow:0 4px 10px rgba(0,0,0,.05); }
    .table-card table{ width:100%; border-collapse:separate; border-spacing:0 10px; text-align:left; }
    .table-card th,.table-card td{ padding:12px; background:#fff; border-radius:8px; vertical-align:top; }
    .table-card th{ background:#f8cdd8; font-weight:600; }

    /* ====== ACTION ICONS ====== */
    .action-icons{ display:flex; gap:12px; align-items:center; flex-wrap:wrap; }
    .action-icons a,.action-icons form{ display:flex; align-items:center; gap:4px; color:#800000; font-size:14px; text-decoration:none; }
    .action-icons button{ background:none; border:none; color:#800000; cursor:pointer; display:flex; align-items:center; gap:4px; font-size:14px; }

    .text-muted  { color:#555; font-style:italic; font-size:13px; }
</style>

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="category-container">

    {{-- Header, optional “Add Delivery”, Search --}}
    <div class="toolbar">
        <div class="header-actions">
            <h1>DELIVERIES</h1>

            {{-- Optional “Add Delivery” button – hide if automatic --}}
            {{-- <a href="{{ route('deliveries.create') }}" class="top-add-btn">
                 <i class="fas fa-plus-circle"></i> Add Delivery
               </a> --}}
        </div>

        <form method="GET" class="search-bar" action="{{ route('deliveries.index') }}">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search deliveries..."
                   autocomplete="off">
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    {{-- Deliveries Table --}}
    <div class="table-section">
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order&nbsp;ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th style="min-width:140px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($deliveries as $delivery)
                        <tr>
                            <td>{{ $delivery->id }}</td>
                            <td>{{ $delivery->order_id }}</td>
                            <td>{{ $delivery->order->delivery_name ?? '—' }}</td>
                            <td>{{ $delivery->order->delivery_phone ?? '—' }}</td>
                            <td>{{ $delivery->order->delivery_address ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($delivery->order->date)->format('d‑M‑Y') }}</td>
                            <td>{{ $delivery->order->time }}</td>
                            <td>{{ ucfirst(str_replace('_',' ', $delivery->status)) }}</td>

                            <td>
                                <div class="action-icons">
                                    {{-- EDIT STATUS --}}
                                    <a href="{{ route('deliveries.edit', $delivery->id) }}" title="Update status">
                                        <i class="fas fa-truck"></i> Edit
                                    </a>

                                    {{-- DELETE (optional) --}}
                                    <form action="{{ route('deliveries.destroy', $delivery->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this delivery record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete delivery">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center;padding:20px;" class="text-muted">
                                No deliveries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
