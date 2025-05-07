<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaveBite Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f9fc;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('https://www.w3schools.com/w3images/food.jpg'); /* Add your own food background image */
            background-size: cover;
            background-position: center;
        }
        a {
            text-decoration: none;
               
        }


        .header {
            background: linear-gradient(to right, #4caf50, rgb(0, 206, 27));
            background-size: 200% 100%; 
            color: white;
            width: 100%;
            padding: 30px 0;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            margin-bottom: 40px;
            border-bottom: 5px solid #388e3c;
            animation: gradientMove 3s ease-in-out 
        }

        @keyframes gradientMove {
            0% {
            background-position: 200% 0;
            }
            100% {
            background-position: -200% 0;
            }
        }

        .header h1 {
            font-size: 4em;
            margin: 0;
            letter-spacing: 2px;
            font-weight: 600;
        }

        .description {
            font-size: 1.0em;
            color: #555;
            text-align: center;
            padding: 0 30px;
            margin-bottom: 50px;
            max-width: 700px;
            animation: float 3s ease-in-out infinite, fadeInUp 1.5s ease-in-out;
        }

        @keyframes float {
            0%, 100% {
            transform: translateY(0);
            }
            50% {
            transform: translateY(-10px);
            }
        }

        @keyframes fadeInUp {
            from {
            opacity: 0;
            transform: translateY(20px);
            }
            to {
            opacity: 1;
            transform: translateY(0);
            }
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 20px;
            flex-wrap: wrap;
            animation: fadeInUp 1.5s ease-in-out;
        }

        .dashboard-button {
            background-color: rgb(89, 89, 89);
            color: white;
            padding: 20px 35px;
            font-size: 1.2em;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
            width: 250px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1); 
        }

        .dashboard-button:hover {
            transform: translateY(-8px); 
            background-color: #4caf50;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15); 
        }

        .dashboard-button i {
            margin-right: 10px;
        }

        .footer {
            margin-top: 60px;
            font-size: 1em;
            color: #888;
            text-align: center;
            animation: fadeInUp 1.5s ease-in-out;
        }

        .footer a {
            color: #4caf50;
            text-decoration: none;
            font-weight: 600;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .social-links {
            margin-top: 10px;
        }

        .social-links a {
            margin: 0 10px;
            color: #4caf50;
            font-size: 1.5em;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: #388e3c;
        }

        @media (max-width: 768px) {
            .button-container {
            flex-direction: column;
            gap: 20px;
            }
        }

    </style>
</head>
<body>

    <div class="header">
        <h1>SaveBite</h1>
    </div>

    <div class="description">
        <p>Selamat datang di <strong>SaveBite Dashboard</strong>! Platform inovatif untuk mengelola data makanan Anda, melacak tanggal kedaluwarsa, dan memastikan makanan Anda tetap segar. Jadikan pengalaman Anda lebih efisien dan bebas khawatir dengan SaveBite.</p>
    </div>

    <div class="button-container">
        <a href="/recipes">
            <button class="dashboard-button">
                <i class="fas fa-utensils"></i> view recipes
            </button>
        </a>
        <a href="/foods/add">
            <button class="dashboard-button">
                <i class="fas fa-plus-circle"></i> Add New Food
            </button>
        </a>
        <a href="/foods">
            <button class="dashboard-button">
                <i class="fas fa-eye"></i> View Food Data
            </button>
        </a>
    </div>

    <div class="footer">
        <p>&copy; 2025 <a href="https://www.youtube.com/watch?v=2e0BMACvymo" target="_blank">SaveBite</a>. All rights reserved.</p>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
