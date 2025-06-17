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

    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .category-header h1 {
        font-weight: bold;
        color: #000;
        font-size: 32px;
    }

    .top-actions {
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .top-actions a {
        text-decoration: none;
        text-align: center;
        color: #800000;
        font-weight: 500;
        font-size: 14px;
    }

    .top-actions i {
        font-size: 28px;
        margin-bottom: 4px;
        color: #800000;
    }

    .search-bar {
        margin: 20px 0;
        display: flex;
        justify-content: start;
    }

    .search-bar input {
        width: 250px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
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
        min-width: 400px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .table-card h3 {
        margin-bottom: 15px;
        color: #fff;
        font-size: 20px;
    }

    .table-card table {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
    }

    .table-card th,
    .table-card td {
        padding: 12px;
        background-color: #fff;
        border-radius: 8px;
    }

    .table-card th {
        background-color: #f8cdd8;
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
</style>

{{-- Font Awesome CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="category-container">
    <div class="category-header">
        <h1>CATEGORY<br><span style="font-size: 20px;">For Service</span></h1>
    </div>

    <div class="search-bar">
        <form method="GET" action="{{ route('decoServices.categories') }}">
            <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" onkeydown="if(event.key === 'Enter'){ this.form.submit(); }">
        </form>
    </div>

    <div class="table-section">
        <div class="table-card">
            <div style="margin-bottom: 15px; font-size: 20px; color: #fff; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                SERVICE
                <a href="{{ route('categories.create') }}" style="background-color: #ffe6ea; color: #800000; padding: 4px 10px; border-radius: 8px; font-weight: 500; font-size: 14px; text-decoration: none; border: 1px solid #800000; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas fa-plus-circle" style="font-size: 16px;"></i> Add
                </a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>CATEGORY</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($categories) && $categories->count() > 0)
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <div class="action-icons">
                                        <a href="{{ route('decoServices.index', $category->id) }}" title="View Services">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('categories.edit', $category->id) }}" title="Edit Category">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category and all its services?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete Category">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" style="text-align: center;">No categories found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
