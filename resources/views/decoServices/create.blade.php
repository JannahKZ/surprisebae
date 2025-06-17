@extends('layouts.guest')

@section('title', 'Create Deco Service')

@push('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(106.37deg, #ffe1bc 29.63%, #ffcfd1 51.55%, #f3c6f1 90.85%);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .main-box {
        background: #ffcbf2;
        padding: 30px;
        border-radius: 20px;
        width: 800px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .main-box h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 28px;
        color: #555;
    }

    form {
        display: flex;
        gap: 30px;
    }

    .left, .right {
        flex: 1;
    }

    label.image-upload {
        background: #fff;
        border-radius: 10px;
        border: 2px dashed #ccc;
        height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin-bottom: 10px;
        outline: none;
    }

    label.image-upload img {
        width: 50px;
        height: 50px;
        opacity: 0.5;
        user-select: none;
        pointer-events: none;
    }

    label.image-upload:focus {
        border-color: #5e60ce;
        box-shadow: 0 0 0 3px rgba(94, 96, 206, 0.5);
    }

    .form-group {
        margin-bottom: 15px;
    }

    label:not(.image-upload) {
        font-size: 12px;
        color: #666;
        font-weight: 500;
        display: block;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    input, select, textarea {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: none;
        font-size: 14px;
    }

    textarea {
        resize: none;
        height: 100px;
    }

    .buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 25px;
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        text-align: center;
        line-height: 32px;
    }

    .btn-add {
        background-color: #5e60ce;
    }

    .btn-back {
        background-color: #06d6a0;
    }
</style>
@endpush

@section('content')
<div class="main-box">
    <h1>Service Information</h1>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('decoServices.store', ['category_id' => old('category_id') ?? $category->id ?? null]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="left">
            <label for="image" class="image-upload" role="button" tabindex="0" aria-label="Upload Image">
                <img src="{{ asset('placeholder-image-icon.png') }}" alt="Upload" />
            </label>
            <input type="file" name="image" id="image" accept="image/*" style="display:none;">

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="right">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" value="{{ old('price') }}" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" required>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" 
                            @if((old('category_id') ?? $category->id ?? '') == $cat->id) selected @endif>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="date">Booked Dates</label>
                <input type="text" id="date" name="date" required autocomplete="off" />
            </div>

            <div class="buttons">
                <button class="btn btn-add" type="submit">ADD</button>
                <a href="{{ url()->previous() }}" class="btn btn-back">BACK</a>
            </div>
        </div>
    </form>
</div>

@php
    $oldDates = old('date');
    $defaultDates = is_array($oldDates) ? $oldDates : ($oldDates ? explode(',', $oldDates) : []);
@endphp

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function () {
        const previewBox = document.querySelector('label.image-upload');
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewBox.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">`;
            };
            reader.readAsDataURL(file);
        } else {
            previewBox.innerHTML = `<img src="{{ asset('placeholder-image-icon.png') }}" alt="Upload" />`;
        }
    });

    // Flatpickr init
    const unavailableDates = @json($unavailableDates ?? []);
    const defaultDates = @json($defaultDates ?? []);

    flatpickr("#date", {
        mode: "multiple",
        dateFormat: "Y-m-d",
        disable: unavailableDates,
        minDate: "today",
        defaultDate: defaultDates
    });
</script>
@endpush
@endsection
