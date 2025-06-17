<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
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

    .register-container {
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

    .register-container h2 {
      color: maroon;
      margin-bottom: 10px;
    }

    .register-container p {
      font-size: 14px;
      color: #555;
      margin-bottom: 20px;
    }

    .register-container p a {
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

    .error {
      color: red;
      font-size: 14px;
      margin-top: 5px;
      margin-left: 10px;
    }
  </style>
</head>
<body>

  <div class="register-container">
    <h2>Register</h2>
    <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Name -->
      <div class="form-group">
        <i class="fa fa-user"></i>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>
        @error('name')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <!-- Email -->
      <div class="form-group">
        <i class="fa fa-envelope"></i>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
        @error('email')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <!-- Password -->
      <div class="form-group">
        <i class="fa fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required>
        @error('password')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <!-- Confirm Password -->
      <div class="form-group">
        <i class="fa fa-lock"></i>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        @error('password_confirmation')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <!-- Submit -->
      <button type="submit" class="btn-primary">REGISTER</button>
    </form>
  </div>

  <!-- FontAwesome for icons -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
