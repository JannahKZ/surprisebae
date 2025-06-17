<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surprise Bae</title>
    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: #f7f7f7;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: rgba(255, 192, 203, 0.85);
            border-radius: 8px 8px 0 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header .logo {
            display: flex;
            align-items: center;
        }

        .header .logo img {
            height: 70px;
            margin-right: 10px;
        }

        .header .logo .name {
            color: #fff;
            font-size: 1.8rem;
            font-weight: bold;
        }

        .content-background {
            position: relative;
            width: 100%;
            height: 50vh;
            margin: 30px 0;
            padding: 0;
            overflow: hidden;
        }

        .content-background::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/image/bg.png') no-repeat center center;
            background-size: cover;
            opacity: 0.75;
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.3);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px 10%;
            text-align: center;
            box-sizing: border-box;
        }

        h1 {
            font-size: 2.5rem;
            color: #3A3960;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            color: #3A3960;
            line-height: 1.8;
            margin-bottom: 20px;
            padding: 0 10%;
        }

        .actions {
            margin-top: 20px;
        }

        .actions .btn {
            background-color: #800000; /* maroon */
            color: #FFF7D1;
            padding: 10px 20px;
            border-radius: 12px;
            border: none;
            margin: 5px;
            text-decoration: none;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .actions .btn:hover {
            background-color: #660000;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px 5%;
            }

            .container p {
                padding: 0;
            }

            .header {
                flex-direction: column;
                text-align: center;
            }

            .header .logo {
                flex-direction: column;
            }

            .header .logo img {
                margin: 0 0 10px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <div class="logo">
            <img src="/image/surprise_bae_logo.png" alt="Logo">
            <div class="name">Surprise Bae</div>
        </div>
    </div>

    <!-- Main Content with Background -->
    <div class="content-background">
        <div class="container">
            <h1>Welcome to Surprise Bae</h1>
            <p>The Reason Someone Smiles Today.</p>
            <div class="actions">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="btn">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</body>
</html>
