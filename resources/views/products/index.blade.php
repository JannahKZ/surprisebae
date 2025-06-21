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

    .search-bar input {
        width: 250px;
        padding: 8px 12px;
        border-radius: 8px 0 0 8px;
        border: 1px solid #ccc;
        border-right: none;
    }

    .search-bar button {
        padding: 8px 16px;
        border-radius: 0 8px 8px 0;
        border: 1px solid #ccc;
        background-color: #800000;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
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
        min-width: 900px;
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
        vertical-align: middle;
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

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 0.5rem;
    }
</style>

{{-- Font Awesome CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="category-container">

    {{-- Header with Add Button and Search --}}
    <div class="toolbar">
        <div class="header-actions">
            <h1>PRODUCT</h1>
            <a href="{{ route('products.create', ['category' => $category->id]) }}" class="top-add-button">
                <i class="fas fa-plus-circle"></i>
                Add
            </a>
        </div>

        <form method="GET" class="search-bar flex">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search products..."
                autocomplete="off"
            />
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    {{-- Product Table --}}
    <div class="table-section">
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                @if ($product->image_path)
                                    <img src="{{ asset('storage/product_images/' . $product->image_path) }}"
                                        alt="{{ $product->name }}"
                                        class="product-image">
                                @else
                                    <span class="text-sm text-gray-500 italic">No image</span>
                                @endif
                            </td>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>RM{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                            <td>
                                <div class="action-icons">
                                    <a href="{{ route('products.edit', $product->id) }}" title="Edit Product">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('products.delete', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete Product">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding: 20px; font-style: italic; color: #800000;">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
