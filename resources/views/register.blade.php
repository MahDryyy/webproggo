<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            animation: fadeIn 1.5s ease-in;
        }
        .container {
            background-color: #fff;
            padding: 40px 50px;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            opacity: 0;
            animation: slideUp 1s forwards;
            animation-delay: 0.5s;
        }
        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 600;
            letter-spacing: 1px;
        }
        label {
            font-size: 16px;
            color: #555;
            text-align: left;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0 25px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
            opacity: 0;
            animation: fadeInInput 0.6s forwards;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #2575fc;
            outline: none;
        }
        button {
            width: 100%;
            padding: 15px;
            background-color: #2575fc;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            opacity: 0;
            animation: fadeInButton 0.8s forwards;
            animation-delay: 0.8s;
        }
        button:hover {
            background-color: #6a11cb;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        p {
            font-size: 14px;
            color: #555;
        }
        a {
            color: #2575fc;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }
        .footer a {
            color: #2575fc;
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes slideUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInInput {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes fadeInButton {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Register</h1>
        <form action="/register" method="POST">
            @csrf
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>

        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        <p>Sudah punya akun? <a href="/login">Login di sini</a></p>

        <div class="footer">
            <p>© 2025 SaveBite. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
