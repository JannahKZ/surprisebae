<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Your existing CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(106.37deg, #ffe1bc 29.63%, #ffcfd1 51.55%, #f3c6f1 90.85%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            height: 100vh;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        .sidebar a.active {
            background-color: #16a085;
        }
      
        :root {
            --yellow: linear-gradient(180deg, #F8D49A -146.42%, #FAD79D -46.42%);
            --orange: #fca61f;
            --black: #242d49;
            --gray: #788097;
            --purple: linear-gradient(180deg, #BB67FF 0%, #C484F3 100%);
            --pink: #FF919D;
            --glass: rgba(255, 255, 255, 0.54);
            --boxShadow: 0px 19px 60px rgb(0 0 0 / 8%);
            --smboxShadow: -79px 51px 60px rgba(0, 0, 0, 0.08);
            --activeItem: #f799a354;
        }

        .main-content {
            color: var(--black);
            background: linear-gradient(
                106.37deg,
                #ffe1bc 29.63%,
                #ffcfd1 51.55%,
                #f3c6f1 90.85%
            );
            flex-grow: 1;
            padding: 20px;
        }

        .content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .content h2 {
            margin: 0 0 20px;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
        }
        .content table th, .orders table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .content table th {
            background-color: #34495e;
            color: #ecf0f1;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 100px;
            border-radius: 50%;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-transform: uppercase;
            text-decoration: none;
        }

        .btn-add {
            background-color: #e84548;
            color: white;
        }
        .btn-add:hover {
            background-color: #e84548;
            transform: translateY(-2px);
        }

        .btn-edit {
            background-color: #007bff;
            color: white;
        }
        .btn-edit:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        table td .actions {
            display: flex;
            gap: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background: #333;
            color: white;
        }

        .container {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: left;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .form-group input, 
        .form-group textarea, 
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        .form-group textarea {
            resize: none;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 14px;
            font-weight: 500;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #218838;
        }
    </style>

    @stack('styles')
</head>
<body>
    @yield('content')

    <!-- Your existing JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @stack('scripts')
</body>
</html>
