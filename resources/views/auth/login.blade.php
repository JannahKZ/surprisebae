<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to bottom right, #ffe4f2, #e0e0ff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      overflow: hidden;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.7);
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(128, 0, 64, 0.2);
      padding: 40px;
      max-width: 400px;
      width: 100%;
      text-align: center;
      backdrop-filter: blur(20px);
      border: 1px solid #ffc0cb;
    }

    .login-container h2 {
      color: maroon;
      margin-bottom: 10px;
    }

    .login-container p {
      font-size: 14px;
      color: #555;
      margin-bottom: 20px;
    }

    .login-container p a {
      color: maroon;
      text-decoration: none;
      font-weight: 600;
    }

    .form-group {
      position: relative;
      margin-bottom: 20px;
      text-align: left;
    }

    .form-group input {
      width: 100%;
      padding: 12px 45px 12px 40px;
      border: 2px solid #d88fa4;
      border-radius: 50px;
      background: white;
      font-size: 14px;
      color: #333;
      box-sizing: border-box;
    }

    .form-group input:focus {
      outline: none;
      border-color: maroon;
    }

    .form-group i {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      left: 15px;
      color: maroon;
      font-size: 16px;
    }

    .form-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 13px;
      color: #333;
      margin-top: 10px;
    }

    .form-actions a {
      color: maroon;
      text-decoration: none;
    }

    .remember-me {
      display: flex;
      align-items: center;
    }

    .remember-me input {
      margin-right: 5px;
    }

    .btn-primary {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      background-color: maroon;
      color: white;
      border: none;
      border-radius: 50px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #a00038;
    }

    /* Optional icons - use fontawesome if needed */
  </style>
</head>
<body>

  <div class="login-container">
    <h2>Login</h2>
    <p>Don't have an account yet? <a href="{{ route('register') }}">Sign Up</a></p>

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <!-- Email -->
      <div class="form-group">
        <i class="fa fa-user"></i>
        <input type="email" name="email" placeholder="Email" required>
      </div>

      <!-- Password -->
      <div class="form-group">
        <i class="fa fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required>
      </div>

      <!-- Remember me and Forgot password -->
      <div class="form-actions">
        <label class="remember-me">
          <input type="checkbox" name="remember"> Keep me logged in
        </label>
        <a href="{{ route('password.request') }}">Forgot Password</a>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn-primary">LOGIN</button>
    </form>
  </div>

  <!-- FontAwesome for icons (optional) -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
