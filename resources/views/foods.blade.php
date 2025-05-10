<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foods</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f4f7fc 0%, #ffffff 100%);
            color: #333;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1 {
            text-align: center;
            color: #4caf50;
            margin-top: 40px;
            font-size: 3em;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            padding-bottom: 10px;
            animation: fadeInDown 1s ease-out;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: #4caf50;
            border-radius: 2px;
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
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        li:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        li::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(76, 175, 80, 0.1);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
            z-index: 0;
        }

        li:hover::before {
            transform: scaleX(1);
        }

        li > * {
            position: relative;
            z-index: 1;
        }

        .recipe-button, button[type="submit"] {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .recipe-button:hover, button[type="submit"]:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .recipe-content {
            background-color: #f1f1f1;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div style="position: absolute; top: 20px; left: 20px;">
        <a href="/dashboard">
            <button style="padding: 10px 20px; background-color: #4caf50; color: white; border: none; border-radius: 8px; font-size: 1em; cursor: pointer;">
                <i class="fas fa-arrow-left"></i>
            </button>
        </a>
    </div>

    <h1 data-aos="fade-up">Foods</h1>

    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    <ul>
        @foreach($foods as $food)
            <li data-aos="fade-up">
                <div>
                    <strong>{{ $food['name'] }}</strong> - Expiry: {{ $food['expiry_date'] }}
                </div>

                <div>
                    <button class="recipe-button" data-food-id="{{ $food['id'] }}">Resep</button>

                    <form action="/foods/{{ $food['id'] }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="fas fa-trash"></i> Delete</button>
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
    AOS.init();

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
