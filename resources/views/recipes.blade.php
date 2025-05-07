<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 30px;
            font-size: 2rem; /* Larger font size for the header */
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); /* Adding a shadow for better contrast */
            border-bottom: 3px solid #333; /* Adding a border for more definition */
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .recipe-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .recipe-card:hover {
            transform: translateY(-5px);
        }

        .recipe-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
        }

        .recipe-info {
            margin-top: 10px;
        }

        .ingredients, .instructions {
            margin: 10px 0;
            font-size: 1rem;
            color: #555;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 1rem;
        }

        .error-message {
            color: red;
            text-align: center;
        }
        .back{
            display: flex;
            justify-content: start;
            margin-left: 20px;
            margin-top: 20px;
        }

        .back button {
            background-color:rgb(73, 73, 73);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .back button:hover {
            background-color: #45a049;
        }
        .back i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Recipe List</h1>
        
    </header>

    <a class="back" href="/dashboard">
            <button>
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </button>
        </a>

    <div class="container">
        @if(session('error'))
            <p class="error-message">{{ session('error') }}</p>
        @endif

        @if(isset($recipes) && !empty($recipes))
            @foreach($recipes as $recipe)
                <div class="recipe-card">
                    <h2 class="recipe-title">Resep:</h2>
                    <div class="recipe-info">
                        {!! nl2br(e($recipe)) !!}
                    </div>
                </div>
            @endforeach
        @else
            <p class="error-message">No recipes available.</p>
        @endif

        <a href="/foods">Back to Foods</a>
    </div>
</body>
</html>
