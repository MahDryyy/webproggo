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
            font-size: 2rem; 
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); 
            border-bottom: 3px solid #333; 
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

        button[type="submit"] {
            background-color: #ff4d4d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button[type="submit"]:hover {
            background-color: #e60000;
            transform: scale(1.05);
        }

        button[type="submit"]:active {
            background-color: #cc0000;
            transform: scale(1);
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

    <div style="position: absolute; top: 20px; left: 20px; border: 2px solid rgb(38, 38, 38); border-radius: 8px; padding: 5px;">
        <a href="/dashboard">
            <button style="padding: 10px 20px; background-color: #4caf50; color: white; border: none; border-radius: 8px; font-size: 1em; cursor: pointer;">
                &lt;
            </button>
        </a>
    </div>
    <header style="font-family: 'Georgia', serif; font-style: italic;">
        <h1 style="font-family: 'Times New Roman', serif;">Recipe List</h1>
        <i style="font-family: 'Palatino Linotype', serif;">Just for you</i>
    </header>

  <div class="container">
    @if(session('error'))
        <p class="error-message" style="color: red;">{{ session('error') }}</p>
    @endif

    @if(!empty($recipes))
        @foreach($recipes as $recipe)
            <div class="recipe-card">
                <h2 class="recipe-title">Recipe:</h2>
                <div class="recipe-info">
                    {!! nl2br(e($recipe['recipe'])) !!}  <!-- Jika $recipe adalah array, akses dengan indeks -->
                </div>
                <!-- Formulir untuk menghapus resep -->
                <form action="{{ route('recipes.delete', $recipe['id']) }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </div>
        @endforeach
    @else
        <p class="error-message" style="color: red;">No recipes available.</p>
    @endif

    <div class="back">
        <a href="/foods"><button><i class="fa fa-arrow-left"></i> Back to Foods</button></a>
    </div>
</div>

</body>
</html>
