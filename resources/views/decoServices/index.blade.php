@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #ffe6ea;
        font-family: 'Poppins', sans-serif;
    }

    .category-container {
        padding: 30px;
    }

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .toolbar h1 {
        font-weight: bold;
        color: #000;
        font-size: 32px;
    }

    .toolbar .header-actions {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .header-actions .top-add-button {
        text-decoration: none;
        text-align: center;
        background-color: #800000;
        color: white;
        font-weight: 500;
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.3s ease;
    }

    .header-actions .top-add-button:hover {
        background-color: #a00000;
    }

    .header-actions .top-add-button i {
        font-size: 16px;
    }

    .search-bar {
        display: flex;
        align-items: center;
        gap: 0;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #ccc;
    }

    .search-bar input {
        width: 250px;
        padding: 8px 12px;
        border: none;
        outline: none;
    }

    .search-bar button {
        background-color: #800000;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
        color: white;
        transition: background-color 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-bar button:hover {
        background-color: #a00000;
    }

    .table-section {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }

    .table-card {
        background-color: #ffb6c1;
        border-radius: 16px;
        padding: 20px;
        flex: 1;
        min-width: 950px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .table-card table {
        width: 100%;
        text-align: left;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table-card th,
    .table-card td {
        padding: 12px;
        background-color: #fff;
        border-radius: 8px;
        vertical-align: top;
        border: none;
    }

    .table-card th {
        background-color: #f8cdd8;
        font-weight: 600;
    }

    .action-icons {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .action-icons a,
    .action-icons form {
        display: flex;
        align-items: center;
        gap: 4px;
        color: #800000;
        font-size: 14px;
        text-decoration: none;
    }

    .action-icons i {
        font-size: 16px;
    }

    .action-icons button {
        background: none;
        border: none;
        color: #800000;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 14px;
    }

    .booked-list {
        margin: 0;
        padding-left: 18px;
    }

    .booked-list li {
        list-style-type: disc;
        margin-bottom: 4px;
        font-size: 13px;
    }

    .text-muted {
        color: #555;
        font-style: italic;
        font-size: 13px;
    }

    /* New product image style */
    .service-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 0.5rem;
    }
</style>

{{-- Font Awesome CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="category-container">

    {{-- Header, Add Button and Search Bar --}}
    <div class="toolbar">
        <div class="header-actions">
            <h1>SERVICES</h1>
            @if ($category)
                <a href="{{ route('decoServices.create', ['category' => $category->id]) }}" class="top-add-button">
                    <i class="fas fa-plus-circle"></i> Add Service
                </a>
            @else
                <span class="text-muted">Select a category to add a service</span>
            @endif
        </div>

        <form method="GET" class="search-bar" action="{{ route('decoServices.index', ['category' => optional($category)->id]) }}">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search services..."
                autocomplete="off"
            />
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-section">
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price (RM)</th>
                        <th>Category</th>
                        <th>Booked Dates</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($decoServices as $decoService)
                        <tr>
                            <td>
                                @if ($decoService->image_path)
                                    <img src="{{ asset('storage/service_images/' . $decoService->image_path) }}" alt="{{ $decoService->name }}" class="service-image" />
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $decoService->id }}</td>
                            <td>{{ $decoService->name }}</td>
                            <td>{{ $decoService->description }}</td>
                            <td>{{ number_format($decoService->price, 2) }}</td>
                            <td>{{ $decoService->category->name ?? 'Uncategorized' }}</td>
                            <td>
                                @if ($decoService->dates->isEmpty())
                                    <span class="text-muted">Not booked</span>
                                @else
                                    <ul class="booked-list">
                                        @foreach ($decoService->dates as $date)
                                            <li>{{ \Carbon\Carbon::parse($date->date)->format('Y-m-d') }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>
                                <div class="action-icons">
                                    <a href="{{ route('decoServices.edit', $decoService->id) }}" title="Edit Service">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('decoServices.delete', $decoService->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete Service">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding: 20px; font-style: italic; color: #800000;">
                                No services found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
