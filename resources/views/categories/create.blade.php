@extends('layouts.app')

@section('content')
<style>
    .create-category-container {
        max-width: 600px;
        margin: 40px auto;
        background-color: #ffe6ea;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        font-family: 'Poppins', sans-serif;
    }

    .create-category-container h1 {
        font-weight: 700;
        color: #800000;
        margin-bottom: 24px;
        font-size: 28px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #4b0000;
    }

    input[type="text"], select {
        width: 100%;
        padding: 10px 14px;
        font-size: 16px;
        border-radius: 8px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus, select:focus {
        border-color: #800000;
        outline: none;
    }

    .btn-submit {
        background-color: #800000;
        color: white;
        font-weight: 600;
        padding: 12px 20px;
        border: none;
        border-radius: 10px;
        width: 100%;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #a00000;
    }

    .error-message {
        color: #cc0000;
        font-size: 14px;
        margin-top: 6px;
    }
</style>

<div class="create-category-container">
    <h1>Add a New Category</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Category Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
            >
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="type">Category Type</label>
            <select id="type" name="type" required>
                <option value="" disabled {{ old('type') ? '' : 'selected' }}>-- Select Type --</option>
                <option value="product" {{ old('type') === 'product' ? 'selected' : '' }}>Product</option>
                <option value="service" {{ old('type') === 'service' ? 'selected' : '' }}>Service</option>
            </select>
            @error('type')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">Add Category</button>
    </form>
</div>
@endsection
