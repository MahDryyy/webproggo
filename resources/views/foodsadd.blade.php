<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Food</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f9fc;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        .form-container h3 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #4caf50;
        }
        .form-container input {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        .form-container input:focus {
            border-color: #4caf50;
            outline: none;
        }
        .form-container button {
            width: 100%;
            padding: 14px;
            background-color: #4caf50;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        p.error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
        .success-message {
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-top: 30px;
            display: none;
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            bottom: 20px;
            width: 80%;
            max-width: 500px;
            animation: slideIn 1s ease-out;
            cursor: pointer;
        }
        .success-message a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(100px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 768px) {
            .form-container {
                padding: 25px;
            }
            .form-container h3 {
                font-size: 1.8em;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <h3>Add New Food</h3>

    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    <form action="/foods" method="POST">
        @csrf
        <label for="name">Food Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter food name" required>
        
        <label for="expiry_date">Expiry Date:</label>
        <input type="date" id="expiry_date" name="expiry_date" required>

        <button type="submit">Add Food</button>
    </form>
</div>

@if(session('success'))
    <div class="success-message" id="successMessage">
        Food added successfully! <br> <a href="/foods">Click here to view foods</a>
    </div>
@endif

<script>
    @if(session('success'))
       
        document.getElementById('successMessage').style.display = 'block';

       
        setTimeout(function() {
            window.location.href = '/foods'; 
        }, 3000);
    @endif
</script>

</body>
</html>
