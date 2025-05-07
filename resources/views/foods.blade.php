<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foods</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #4caf50;
            margin-top: 40px;
            font-size: 3em;
        }

        h3 {
            color: #4caf50;
            margin-bottom: 10px;
        }

        ul {
            padding: 0;
            list-style-type: none;
            margin: 20px;
        }

        li {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        li:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .recipe-button, button[type="submit"] {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .recipe-button:hover, button[type="submit"]:hover {
            background-color: #45a049;
        }

        .recipe-content {
            background-color: #f1f1f1;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .loading {
            color: #4caf50;
            font-size: 18px;
            display: inline-block;
            padding: 10px;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1em;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #4caf50;
            border: none;
            border-radius: 5px;
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
            text-align: center;
            font-weight: bold;
        }

        .add-food-button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #4caf50;
            color: white;
            font-size: 1.2em;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 30px;
            text-align: center;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .add-food-button:hover {
            background-color: #45a049;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .success-message {
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin-top: 30px;
            display: none;
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            bottom: 20px;
            width: 80%;
            max-width: 400px;
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
    </style>
</head>
<body>

    <h1>Foods</h1>

    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    <ul>
        @foreach($foods as $food)
            <li>
                <div>
                    <strong>{{ $food['name'] }}</strong> - Expiry: {{ $food['expiry_date'] }}
                </div>

                <div>
                    <button class="recipe-button" data-food-id="{{ $food['id'] }}">Resep</button>

                    <form action="/foods/{{ $food['id'] }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </div>

                <div id="recipe-{{ $food['id'] }}" class="recipe-content">
                </div>
            </li>
        @endforeach
    </ul>

    @if(session('success'))
        <div class="success-message" id="successMessage">
            Food added successfully! <br> <a href="/foods">Click here to view foods</a>
        </div>
    @endif

    <script>
    $(document).ready(function() {
        $('.recipe-button').click(function() {
            var foodId = $(this).data('food-id');
            var recipeContent = $('#recipe-' + foodId);

            if (recipeContent.is(':visible')) {
                recipeContent.fadeOut();
                return;
            }

            recipeContent.html('<div class="loading">Loading...</div>').fadeIn();

            $.ajax({
                url: '/recipe',
                method: 'POST',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    food_id: foodId
                }),
                contentType: 'application/json',
                success: function(response) {
                    if (response.recipe) {
                        var formattedRecipe = formatRecipe(response.recipe);
                        recipeContent.html(formattedRecipe).fadeIn();
                    } else {
                        recipeContent.html('<p>Resep tidak ditemukan.</p>').fadeIn();
                    }
                },
                error: function(xhr, status, error) {
                    recipeContent.html('<p>Terjadi kesalahan saat memproses request.</p>').fadeIn();
                }
            });
        });

        function formatRecipe(recipeText) {
            var formattedText = recipeText;

            formattedText = formattedText.replace(/## (.*?) ##/g, '<h3>$1</h3>');
            formattedText = formattedText.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            formattedText = '<p>' + formattedText.replace(/\n/g, '</p><p>') + '</p>';
            formattedText = formattedText.replace(/(\d+\.|•) (.*?)<\/strong>/g, '<ul><li>$2</li></ul>');

            return formattedText;
        }

    });
    </script>

</body>
</html>
