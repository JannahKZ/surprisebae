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
        color: #800000; /* maroon */
        font-weight: 500;
        font-size: 14px;
    }

    .top-actions i {
        font-size: 28px;
        margin-bottom: 4px;
        color: #800000; /* maroon */
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

    .table-card td {
        background-color: #fff;
    }

</style>

{{-- Font Awesome CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="category-container">
    <div class="category-header">
        <h1>CATEGORY</h1>
        <div class="top-actions">
            <a href="{{ route('categories.create') }}">
                <i class="fas fa-plus-circle"></i><br>Add
            </a>
            <a href="#">
                <i class="fas fa-edit"></i><br>Edit
            </a>
            <a href="#">
                <i class="fas fa-trash-alt"></i><br>Delete
            </a>
        </div>
    </div>

    <div class="search-bar">
        <input type="text" placeholder="Search...">
    </div>

    <div class="table-section">
        <div class="table-card">
            <h3>PRODUCT</h3>
            <table>
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>PRODUCT</th>
                    </tr>
                </thead>
                <tbody>
                    @php $productNo = 1; @endphp
                    @foreach ($categories->where('type', 'product') as $category)
                        <tr>
                            <td>{{ $productNo++ }}</td>
                            <td>{{ $category->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-card">
            <h3>SERVICE</h3>
            <table>
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>SERVICE</th>
                    </tr>
                </thead>
                <tbody>
                    @php $serviceNo = 1; @endphp
                    @foreach ($categories->where('type', 'service') as $category)
                        <tr>
                            <td>{{ $serviceNo++ }}</td>
                            <td>{{ $category->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
