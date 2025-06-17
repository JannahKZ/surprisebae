<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Surprise Bae')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            display: flex;
        }

        .sidebar {
            width: 260px;
            background-color: #420303;
            color: white;
            height: 100vh;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            transition: width 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
        }

        .sidebar.collapsed {
            width: 80px;
            align-items: center;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 15px;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .logo-container h2 {
            display: none;
        }

        .logo {
            width: 60px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            margin-bottom: 20px;
            align-self: flex-end;
        }

        .menu {
            width: 100%;
        }

        .menu a {
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            margin: 3px 0;
            font-size: 14px;
            transition: background 0.3s;
            display: flex;
            align-items: center;
        }

        .menu a:hover,
        .menu a.active {
            background-color: #a83268;
        }

        .menu a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar.collapsed .menu a span {
            display: none;
        }

        .logout-button {
            margin-top: auto;
            background-color: white;
            color: #6f1d4c;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            width: 100%;
        }

        .logout-button i {
            margin-right: 10px;
            width: 18px;
            text-align: center;
        }

        .sidebar.collapsed .logout-button span {
            display: none;
        }

        .main-content {
            flex-grow: 1;
            background: linear-gradient(
                106.37deg,
                #ffe1bc 29.63%,
                #ffcfd1 51.55%,
                #f3c6f1 90.85%
            );
            padding: 30px;
            min-height: 100vh;
            transition: margin-left 0.3s;
            margin-left: 260px;
        }

        .main-content.collapsed {
            margin-left: 80px;
        }

        /* Custom dropdown for reports */
        .dropdown {
            width: 100%;
            position: relative;
        }

        .dropdown-button {
            width: 100%;
            background: none;
            border: none;
            color: white;
            padding: 12px 18px;
            font-size: 14px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            border-radius: 10px;
            cursor: pointer;
        }

        .dropdown-button i {
            width: 16px;
            text-align: center;
            margin-right: 10px;
            font-size: 13px;
        }

        .dropdown-button:hover {
            background-color: #a83268;
        }

        .dropdown-menu {
            display: none;
            flex-direction: column;
            padding-left: 20px;
            margin-top: 5px;
        }

        .dropdown-menu a {
            color: white;
            font-size: 13px;
            padding: 8px 10px;
            border-radius: 8px;
        }

        .dropdown-menu a:hover {
            background-color: #a83268;
        }

        .dropdown.open .dropdown-menu {
            display: flex;
        }

        .sidebar.collapsed .dropdown-button i.fa-caret-down {
            display: none;
        }

        .sidebar.collapsed .dropdown-button {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .dropdown-button i {
            margin-right: 0;
        }

        .sidebar.collapsed .dropdown-menu {
            display: none !important;
        }

        .icon-text-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sidebar.collapsed .dropdown-text {
            display: none;
        }
        </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <div class="logo-container">
            <img src="{{ asset('image/surprise_bae_logo.png') }}" alt="Surprise Bae Logo" class="logo">
            <h2>SURPRISE BAE</h2>
        </div>

        <nav class="menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-house"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('products.categories') }}" class="{{ request()->routeIs('products.categories') ? 'active' : '' }}">
                <i class="fas fa-box-open"></i> <span>Product</span>
            </a>
            <a href="{{ route('decoServices.categories') }}" class="{{ request()->routeIs('decoServices.categories') ? 'active' : '' }}">
                <i class="fas fa-hand-sparkles"></i> <span>Service</span>
            </a>
            <a href="{{ route('deliveries.index') }}" class="{{ request()->routeIs('deliveries.index') ? 'active' : '' }}">
                <i class="fas fa-truck"></i> <span>Delivery</span>
            </a>

            <!-- Reports Dropdown (Click Only) -->
            <div class="dropdown" id="reportDropdown">
                <button class="dropdown-button" onclick="toggleReportsMenu(event)">
                    <span class="icon-text-wrapper">
                        <i class="fas fa-chart-line"></i>
                        <span class="dropdown-text">Reports</span>
                    </span>
                    <i class="fas fa-caret-down"></i>
                </button>
                <div class="dropdown-menu">
                    <a href="{{ route('reports.salesSummary') }}" class="{{ request()->routeIs('reports.salesSummary') ? 'active' : '' }}">Sales Summary</a>
                    <a href="{{ route('reports.inventory') }}" class="{{ request()->routeIs('reports.inventory') ? 'active' : '' }}">Inventory</a>
                    <a href="{{ route('reports.salesHighlight') }}" class="{{ request()->routeIs('reports.salesHighlight') ? 'active' : '' }}">Sales Highlight</a>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                @csrf
                <button type="submit" class="logout-button">
                    <i class="fas fa-sign-out-alt"></i> <span>Log Out</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <main>
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('main-content');
            const reportDropdown = document.getElementById('reportDropdown');

            sidebar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');

            // Close report dropdown if open
            if (sidebar.classList.contains('collapsed')) {
                reportDropdown.classList.remove('open');
            }
        }

        function toggleReportsMenu(event) {
            event.stopPropagation(); // Prevent from closing immediately
            const dropdown = document.getElementById('reportDropdown');
            dropdown.classList.toggle('open');
        }

        // Close dropdown if clicked outside
        document.addEventListener('click', function (e) {
            const dropdown = document.getElementById('reportDropdown');
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });
    </script>

</body>
</html>
