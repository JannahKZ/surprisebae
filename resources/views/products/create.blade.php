@extends('layouts.guest')

@section('content')
<head>
    <title>Product Information</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(
                106.37deg,
                #ffe1bc 29.63%,
                #ffcfd1 51.55%,
                #f3c6f1 90.85%
            );
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

        .image-upload {
            background: #fff;
            border-radius: 10px;
            border: 2px dashed #ccc;
            height: 280px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .image-upload img {
            width: 50px;
            height: 50px;
            opacity: 0.5;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
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
        }

        .btn-add {
            background-color: #5e60ce;
        }

        .btn-back {
            background-color: #06d6a0;
        }
    </style>
</head>
<body>
    <div class="main-box">
        <h1>Product Information</h1>
        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store', ['category' => $category_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="left">
                <label for="image">Upload Image:</label>
                <div class="image-upload" onclick="document.getElementById('image').click();">
                    <img src="{{ asset('placeholder-image-icon.png') }}" alt="Upload" />
                </div>
                <input type="file" name="image" id="image" accept="image/*" style="display:none;">

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"></textarea>
                </div>

            </div>
            <div class="right">
                <div class="form-group">
                    <label for="product_id">ID</label>
                    <input type="text" id="product_id" name="product_id" required>
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" id="price" name="price" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                        <input type="number" step="1" id="stock" name="stock" required>
                </div> 

                <div class="buttons">
                    <button class="btn btn-add" type="submit">ADD</button>
                    <a href="{{ url()->previous() }}" class="btn btn-back">BACK</a>
                </div>
            </div>
        </form>
        <script>
            document.getElementById('image').addEventListener('change', function () {
                const previewBox = document.querySelector('.image-upload');
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
        </script>

    </div>
</body>
@endsection
