<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #ff1493;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            color: #721c24;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 150px; /* ajustez la taille du logo selon vos besoins */
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="logo">
            <img src="https://technext.github.io/famms/images/logo.png" alt="Logo">
        </div>
        <h2>Register</h2>
        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('custom.registerSec') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input id="name" type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input id="email" type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
</body>
</html>
